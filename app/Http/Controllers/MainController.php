<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Corte;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Services\Operations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function index(Request $request)
{
    $userId = session('user')['id'];
    $user = User::find($userId);
    $search = trim($request->input('search', ''));
    $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

    $cortes = Corte::with('user')
        ->when($search !== '', function ($query) use ($search) {
            $query->where('nome_corte', 'like', "%{$search}%");
        })
        ->orderBy('created_at', $order)
        ->paginate(9)
        ->withQueryString();

    return view('home', [
        'cortes' => $cortes,
        'user' => $user,
        'search' => $search,
        'order' => $request->input('order') === 'oldest' ? 'oldest' : 'recent',
    ]);
}

    public function exportPdf(Request $request)
    {
        $userId = session('user')['id'];
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $cortes = Corte::where('user_id', $userId)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome_corte', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.cortes', [
            'cortes' => $cortes,
            'search' => $search,
        ])
            ->setPaper('a4', 'portrait')
            ->download('lista-de-cortes.pdf');
    }

    public function exportTrashedCutsPdf(Request $request)
    {
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $cortes = Corte::onlyTrashed()
            ->where('user_id', session('user')['id'])
            ->orderBy('deleted_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.cortes_lixeira', ['cortes' => $cortes])
            ->setPaper('a4', 'portrait')
            ->download('lixeira-de-cortes.pdf');
    }

    public function exportTrashedProductsPdf(Request $request)
    {
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $produtos = Produto::onlyTrashed()
            ->where('user_id', session('user')['id'])
            ->orderBy('deleted_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.produtos_lixeira', ['produtos' => $produtos])
            ->setPaper('a4', 'landscape')
            ->download('lixeira-de-produtos.pdf');
    }

    public function exportTrashedSuppliersPdf(Request $request)
    {
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $fornecedores = Fornecedor::onlyTrashed()
            ->withCount('produtos')
            ->where('user_id', session('user')['id'])
            ->orderBy('deleted_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.fornecedores_lixeira', ['fornecedores' => $fornecedores])
            ->setPaper('a4', 'landscape')
            ->download('lixeira-de-fornecedores.pdf');
    }

    public function exportTrashedClientsPdf(Request $request)
    {
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $clientes = User::onlyTrashed()
            ->where('role', 'cliente')
            ->orderBy('deleted_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.clientes_lixeira', ['clientes' => $clientes])
            ->setPaper('a4', 'portrait')
            ->download('lixeira-de-clientes.pdf');
    }

    public function newCorte()
    {
        return view('new_corte');
    }

    public function newCorteSubmit(Request $request)
    {
        $request->validate([
            'nome_corte' => 'required|min:3|max:100',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'preco' => 'required|numeric|min:0',
        ], [
            'nome_corte.required' => 'Informe o nome do corte.',
            'nome_corte.min' => 'O nome do corte deve ter pelo menos :min caracteres.',
            'nome_corte.max' => 'O nome do corte deve ter no máximo :max caracteres.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar em formato JPG, PNG, GIF ou WEBP.',
            'imagem.max' => 'A imagem não pode ultrapassar 2 MB.',
            'preco.required' => 'Informe o preço do corte.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
        ]);

        $id = session('user')['id'];

        $corte = new Corte();
        $corte->user_id = $id;
        $corte->nome_corte = $request->nome_corte;
        $corte->imagem = $request->file('imagem')?->store('cortes', 'public');
        $corte->preco = $request->preco;
        $corte->save();

        return redirect()->route('home');
    }

    public function editCorte($id)
    {
        $userId = session('user')['id'];
        $decrypted_id = Operations::decryptId($id);

        $corte = Corte::where('id', $decrypted_id)
            ->where('user_id', $userId)
            ->first();

        if (!$corte) {
            return redirect()->route('home');
        }

        return view('edit_corte', ['corte' => $corte]);
    }

    public function editCorteSubmit(Request $request)
    {
        if ($request->corte_id === null) {
            return redirect()->route('home');
        }

        $request->validate([
            'nome_corte' => 'required|min:3|max:100',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'preco' => 'required|numeric|min:0',
        ], [
            'nome_corte.required' => 'Informe o nome do corte.',
            'nome_corte.min' => 'O nome do corte deve ter pelo menos :min caracteres.',
            'nome_corte.max' => 'O nome do corte deve ter no máximo :max caracteres.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar em formato JPG, PNG, GIF ou WEBP.',
            'imagem.max' => 'A imagem não pode ultrapassar 2 MB.',
            'preco.required' => 'Informe o preço do corte.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
        ]);

        $userId = session('user')['id'];
        $id = Operations::decryptId($request->corte_id);

        $corte = Corte::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$corte) {
            return redirect()->route('home');
        }

        $corte->nome_corte = $request->nome_corte;
        if ($request->hasFile('imagem')) {
            if ($corte->imagem) {
                Storage::disk('public')->delete($corte->imagem);
            }

            $corte->imagem = $request->file('imagem')->store('cortes', 'public');
        }
        $corte->preco = $request->preco;
        $corte->save();

        return redirect()->route('home');
    }

    public function deleteCorte($id)
    {
        $userId = session('user')['id'];
        $corteId = Operations::decryptId($id);

        $corte = Corte::where('id', $corteId)
            ->where('user_id', $userId)
            ->first();

        if ($corte) {
            $corte->delete();
        }

        return redirect()->route('home');
    }

    public function deleteCorteConfirm($id)
    {
        $userId = session('user')['id'];
        $corteId = Operations::decryptId($id);

        $corte = Corte::onlyTrashed()
            ->where('id', $corteId)
            ->where('user_id', $userId)
            ->first();

        if (!$corte) {
            return redirect()->route('lixeira');
        }

        return view('delete_corte', ['corte' => $corte]);
    }

    public function lixeira()
    {
        $userId = session('user')['id'];
        $order = request()->input('order') === 'oldest' ? 'asc' : 'desc';

        $cortes = Corte::onlyTrashed()
            ->where('user_id', $userId)
            ->orderBy('deleted_at', $order)
            ->paginate(9, ['*'], 'cortes_page')
            ->withQueryString();

        $produtos = Produto::onlyTrashed()
            ->where('user_id', $userId)
            ->orderBy('deleted_at', $order)
            ->paginate(9, ['*'], 'produtos_page')
            ->withQueryString();

        $fornecedores = Fornecedor::onlyTrashed()
            ->where('user_id', $userId)
            ->orderBy('deleted_at', $order)
            ->paginate(9, ['*'], 'fornecedores_page')
            ->withQueryString();

        $clientes = User::onlyTrashed()
            ->where('role', 'cliente')
            ->orderBy('deleted_at', $order)
            ->paginate(9, ['*'], 'clientes_page')
            ->withQueryString();

        return view('trash', [
            'cortes' => $cortes,
            'produtos' => $produtos,
            'fornecedores' => $fornecedores,
            'clientes' => $clientes,
            'order' => request()->input('order') === 'oldest' ? 'oldest' : 'recent',
        ]);
    }

    public function restoreCorte($id)
    {
        $userId = session('user')['id'];
        $corteId = Operations::decryptId($id);

        $corte = Corte::onlyTrashed()
            ->where('id', $corteId)
            ->where('user_id', $userId)
            ->first();

        if ($corte) {
            $corte->restore();
        }

        return redirect()->route('home');
    }

    public function forceDeleteCorte($id)
    {
        $userId = session('user')['id'];
        $corteId = Operations::decryptId($id);

        $corte = Corte::onlyTrashed()
            ->where('id', $corteId)
            ->where('user_id', $userId)
            ->first();

        if ($corte) {
            if ($corte->imagem) {
                Storage::disk('public')->delete($corte->imagem);
            }

            $corte->forceDelete();
        }

        return redirect()->route('lixeira');
    }
}
