<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Fornecedor;
use App\Models\User;
use App\Services\Operations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user')['id'];
        $user = User::find($userId);
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $produtos = Produto::with(['fornecedor', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->paginate(9)
            ->withQueryString();

        return view('produtos', [
            'produtos' => $produtos,
            'user' => $user,
            'search' => $search,
            'order' => $request->input('order') === 'oldest' ? 'oldest' : 'recent',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $produtos = Produto::with('fornecedor')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.produtos', [
            'produtos' => $produtos,
            'search' => $search,
        ])
            ->setPaper('a4', 'landscape')
            ->download('lista-de-produtos.pdf');
    }

    public function exportExcel(Request $request)
    {
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $produtos = Produto::with('fornecedor')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->orderBy('id', $order)
            ->get();

        return response()->streamDownload(function () use ($produtos) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, [
                'Produto',
                'Fornecedor',
                'Descrição',
                'Preço',
                'Estoque',
                'Cadastrado em',
            ], ';', '"', '');

            foreach ($produtos as $produto) {
                fputcsv($output, [
                    $this->excelSafeText($produto->nome),
                    $this->excelSafeText($produto->fornecedor?->nome ?? 'Não informado'),
                    $this->excelSafeText($produto->descricao ?? ''),
                    number_format((float) $produto->preco, 2, ',', ''),
                    $produto->quantidade,
                    $produto->created_at?->format('d/m/Y'),
                ], ';', '"', '');
            }

            fclose($output);
        }, 'lista-de-produtos.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function create()
    {
        return view('new_produto', [
            'fornecedores' => $this->activeSuppliers(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        $validated['user_id'] = session('user')['id'];
        $validated['imagem'] = $request->file('imagem')?->store('produtos', 'public');

        Produto::create($validated);

        return redirect()->route('produtos.index');
    }

    public function edit($id)
    {
        $produto = $this->findOwnedProduct($id);

        if (!$produto) {
            return redirect()->route('produtos.index');
        }

        return view('edit_produto', [
            'produto' => $produto,
            'fornecedores' => $this->activeSuppliers(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $produto = $this->findOwnedProduct($id);

        if (!$produto) {
            return redirect()->route('produtos.index');
        }

        $validated = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('imagem')) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $validated['imagem'] = $request->file('imagem')->store('produtos', 'public');
        } else {
            unset($validated['imagem']);
        }

        $produto->update($validated);

        return redirect()->route('produtos.index');
    }

    public function adjustStock(Request $request, string $operacao)
    {
        if (!in_array($operacao, ['aumentar', 'diminuir'], true)) {
            abort(404);
        }

        $user = User::find(session('user.id'));
        abort_unless($user?->isBarbeiro(), 403);

        $request->validate([
            'produto_id' => ['required', 'string'],
        ]);

        $decryptedId = Operations::decryptId($request->input('produto_id'));

        if (!is_numeric($decryptedId)) {
            return redirect()->route('produtos.index');
        }

        $produto = Produto::find($decryptedId);

        if (!$produto) {
            return redirect()->route('produtos.index');
        }

        $query = Produto::whereKey($produto->id);

        if ($operacao === 'aumentar') {
            $alterados = $query->where('quantidade', '<', 1000000)->increment('quantidade');
        } else {
            $alterados = $query->where('quantidade', '>', 0)->decrement('quantidade');
        }

        if ($alterados === 0) {
            return back()->with('error', $operacao === 'aumentar'
                ? 'O estoque não pode ultrapassar 1.000.000 unidades.'
                : 'O estoque não pode ficar abaixo de zero.');
        }

        return back()->with('success', 'Estoque atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $produto = $this->findOwnedProduct($id);

        if ($produto) {
            $produto->delete();
        }

        return redirect()->route('produtos.index');
    }

    public function restore($id)
    {
        $produto = $this->findOwnedProduct($id, true);

        if ($produto) {
            $produto->restore();
        }

        return redirect()->route('lixeira');
    }

    public function confirmForceDelete($id)
    {
        $produto = $this->findOwnedProduct($id, true);

        if (!$produto) {
            return redirect()->route('lixeira');
        }

        return view('delete_produto', ['produto' => $produto]);
    }

    public function forceDelete($id)
    {
        $produto = $this->findOwnedProduct($id, true);

        if ($produto) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }

            $produto->forceDelete();
        }

        return redirect()->route('lixeira');
    }

    private function findOwnedProduct($id, bool $withTrashed = false): ?Produto
    {
        $decryptedId = Operations::decryptId($id);

        if (!is_numeric($decryptedId)) {
            return null;
        }

        $query = $withTrashed ? Produto::onlyTrashed() : Produto::query();

        return $query
            ->where('id', $decryptedId)
            ->where('user_id', session('user')['id'])
            ->first();
    }

    private function rules(): array
    {
        return [
            'nome' => 'required|string|min:2|max:100',
            'descricao' => 'nullable|string|max:1000',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'preco' => 'required|numeric|min:0|max:999999.99',
            'quantidade' => 'required|integer|min:0|max:1000000',
            'fornecedor_id' => [
                'nullable',
                'integer',
                Rule::exists('fornecedores', 'id')
                    ->where('user_id', session('user')['id'])
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    private function activeSuppliers()
    {
        return Fornecedor::where('user_id', session('user')['id'])
            ->orderBy('nome')
            ->get();
    }

    private function excelSafeText(string $value): string
    {
        return preg_match('/^[\t\r\n ]*[=+\-@]/', $value) === 1
            ? "'" . $value
            : $value;
    }

    private function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do produto.',
            'nome.min' => 'O nome do produto deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome do produto deve ter no máximo :max caracteres.',
            'descricao.max' => 'A descrição deve ter no máximo :max caracteres.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar em formato JPG, PNG, GIF ou WEBP.',
            'imagem.max' => 'A imagem não pode ultrapassar 2 MB.',
            'preco.required' => 'Informe o preço do produto.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
            'preco.max' => 'O preço não pode ultrapassar R$ 999.999,99.',
            'quantidade.required' => 'Informe a quantidade em estoque.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade não pode ser negativa.',
            'quantidade.max' => 'A quantidade não pode ultrapassar :max unidades.',
        ];
    }
}
