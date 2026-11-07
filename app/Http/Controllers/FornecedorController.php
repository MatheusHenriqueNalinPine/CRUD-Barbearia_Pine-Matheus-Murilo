<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $fornecedores = Fornecedor::withCount('produtos')
            ->where('user_id', session('user')['id'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
            })
            ->orderBy('nome')
            ->get();

        return view('fornecedores', [
            'fornecedores' => $fornecedores,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('new_fornecedor');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());
        $validated['user_id'] = session('user')['id'];

        Fornecedor::create($validated);

        return redirect()->route('fornecedores.index');
    }

    public function edit($id)
    {
        $fornecedor = $this->findOwnedSupplier($id);

        if (!$fornecedor) {
            return redirect()->route('fornecedores.index');
        }

        return view('edit_fornecedor', ['fornecedor' => $fornecedor]);
    }

    public function update(Request $request, $id)
    {
        $fornecedor = $this->findOwnedSupplier($id);

        if (!$fornecedor) {
            return redirect()->route('fornecedores.index');
        }

        $fornecedor->update($request->validate($this->rules(), $this->messages()));

        return redirect()->route('fornecedores.index');
    }

    public function destroy($id)
    {
        $fornecedor = $this->findOwnedSupplier($id);

        if ($fornecedor) {
            DB::transaction(function () use ($fornecedor) {
                $fornecedor->produtos()->update(['fornecedor_id' => null]);
                $fornecedor->delete();
            });
        }

        return redirect()->route('fornecedores.index');
    }

    public function restore($id)
    {
        $fornecedor = $this->findOwnedSupplier($id, true);

        if ($fornecedor) {
            $fornecedor->restore();
        }

        return redirect()->route('lixeira');
    }

    public function confirmForceDelete($id)
    {
        $fornecedor = $this->findOwnedSupplier($id, true);

        if (!$fornecedor) {
            return redirect()->route('lixeira');
        }

        return view('delete_fornecedor', ['fornecedor' => $fornecedor]);
    }

    public function forceDelete($id)
    {
        $fornecedor = $this->findOwnedSupplier($id, true);

        if ($fornecedor) {
            $fornecedor->forceDelete();
        }

        return redirect()->route('lixeira');
    }

    private function findOwnedSupplier($id, bool $withTrashed = false): ?Fornecedor
    {
        $decryptedId = Operations::decryptId($id);

        if (!is_numeric($decryptedId)) {
            return null;
        }

        $query = $withTrashed ? Fornecedor::onlyTrashed() : Fornecedor::query();

        return $query
            ->where('id', $decryptedId)
            ->where('user_id', session('user')['id'])
            ->first();
    }

    private function rules(): array
    {
        return [
            'nome' => 'required|string|min:2|max:100',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:30',
            'endereco' => 'nullable|string|max:255',
        ];
    }

    private function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do fornecedor.',
            'nome.min' => 'O nome do fornecedor deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome do fornecedor deve ter no máximo :max caracteres.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'telefone.max' => 'O telefone deve ter no máximo :max caracteres.',
            'endereco.max' => 'O endereço deve ter no máximo :max caracteres.',
        ];
    }
}
