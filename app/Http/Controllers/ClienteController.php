<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Corte;
use App\Services\Operations;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user')['id'];
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $clientes = Cliente::with('corteFavorito')
            ->where('user_id', $userId)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->paginate(9)
            ->withQueryString();

        return view('clientes', [
            'clientes' => $clientes,
            'search' => $search,
            'order' => $request->input('order') === 'oldest' ? 'oldest' : 'recent',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $userId = session('user')['id'];
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $clientes = Cliente::with('corteFavorito')
            ->where('user_id', $userId)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('created_at', $order)
            ->orderBy('id', $order)
            ->get();

        return Pdf::loadView('pdf.clientes', [
            'clientes' => $clientes,
            'search' => $search,
        ])
            ->setPaper('a4', 'portrait')
            ->download('lista-de-clientes.pdf');
    }

    public function create()
    {
        return view('new_cliente', [
            'cortes' => $this->activeCuts(),
            'tiposCabelo' => Cliente::TIPOS_CABELO,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        $validated['user_id'] = session('user')['id'];

        Cliente::create($validated);

        return redirect()->route('clientes.index');
    }

    public function edit($id)
    {
        $cliente = $this->findOwnedClient($id);

        if (!$cliente) {
            return redirect()->route('clientes.index');
        }

        return view('edit_cliente', [
            'cliente' => $cliente,
            'cortes' => $this->activeCuts(),
            'tiposCabelo' => Cliente::TIPOS_CABELO,
        ]);
    }

    public function update(Request $request, $id)
    {
        $cliente = $this->findOwnedClient($id);

        if (!$cliente) {
            return redirect()->route('clientes.index');
        }

        $cliente->update($request->validate($this->rules(), $this->messages()));

        return redirect()->route('clientes.index');
    }

    public function destroy($id)
    {
        $cliente = $this->findOwnedClient($id);

        if ($cliente) {
            $cliente->delete();
        }

        return redirect()->route('clientes.index');
    }

    public function restore($id)
    {
        $cliente = $this->findOwnedClient($id, true);

        if ($cliente) {
            $cliente->restore();
        }

        return redirect()->route('lixeira');
    }

    public function confirmForceDelete($id)
    {
        $cliente = $this->findOwnedClient($id, true);

        if (!$cliente) {
            return redirect()->route('lixeira');
        }

        return view('delete_cliente', ['cliente' => $cliente]);
    }

    public function forceDelete($id)
    {
        $cliente = $this->findOwnedClient($id, true);

        if ($cliente) {
            $cliente->forceDelete();
        }

        return redirect()->route('lixeira');
    }

    private function activeCuts()
    {
        return Corte::where('user_id', session('user')['id'])
            ->orderBy('nome_corte')
            ->get();
    }

    private function findOwnedClient($id, bool $withTrashed = false): ?Cliente
    {
        $decryptedId = Operations::decryptId($id);

        if (!is_numeric($decryptedId)) {
            return null;
        }

        $query = $withTrashed ? Cliente::onlyTrashed() : Cliente::query();

        return $query
            ->where('id', $decryptedId)
            ->where('user_id', session('user')['id'])
            ->first();
    }

    private function rules(): array
    {
        return [
            'nome' => 'required|string|min:2|max:100',
            'tipo_cabelo' => ['required', Rule::in(array_keys(Cliente::TIPOS_CABELO))],
            'corte_favorito_id' => [
                'nullable',
                'integer',
                Rule::exists('cortes', 'id')
                    ->where('user_id', session('user')['id'])
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    private function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do cliente.',
            'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'tipo_cabelo.required' => 'Selecione o tipo de cabelo.',
            'tipo_cabelo.in' => 'Selecione um tipo de cabelo válido.',
            'corte_favorito_id.exists' => 'Selecione um corte válido cadastrado para sua barbearia.',
        ];
    }
}
