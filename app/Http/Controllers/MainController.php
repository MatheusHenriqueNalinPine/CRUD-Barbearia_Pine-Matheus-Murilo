<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Corte;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function  newCorte()
    {
        return view('new_corte');
    }

    public function newCorteSubmit(Request $request)
    {
        $request->validate([
            'nome_corte' => 'required|min:3|max:100',
            'preco' => 'required|numeric|min:0',
        ], [
            'nome_corte.required' => 'Informe o nome do corte.',
            'nome_corte.min' => 'O nome do corte deve ter pelo menos :min caracteres.',
            'nome_corte.max' => 'O nome do corte deve ter no máximo :max caracteres.',
            'preco.required' => 'Informe o preço do corte.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
        ]);

        $id = session('user')['id'];

        $corte = new Corte();
        $corte->user_id = $id;
        $corte->nome_corte = $request->nome_corte;
        $corte->preco = $request->preco;
        $corte->save();

        return redirect()->route('home');
    }

    public function editCorte($id)
    {
        $decrypted_id = Operations::decryptId($id);

        $corte = Corte::find($decrypted_id);

        return view('edit_corte', ['corte' => $corte]);
    }

    public function editCorteSubmit(Request $request)
    {
        if ($request->corte_id === null) {
            return redirect()->route('home');
        }

        $request->validate([
            'nome_corte' => 'required|min:3|max:100',
            'preco' => 'required|numeric|min:0',
        ], [
            'nome_corte.required' => 'Informe o nome do corte.',
            'nome_corte.min' => 'O nome do corte deve ter pelo menos :min caracteres.',
            'nome_corte.max' => 'O nome do corte deve ter no máximo :max caracteres.',
            'preco.required' => 'Informe o preço do corte.',
            'preco.numeric' => 'O preço deve ser um valor numérico.',
            'preco.min' => 'O preço não pode ser negativo.',
        ]);

        // Desencriptar o ID
        $id = Operations::decryptId($request->corte_id);

        // Carregar o corte
        $corte = Corte::find($id);

        if (!$corte) {
            return redirect()->route('home');
        }

        $corte->nome_corte = $request->nome_corte;
        $corte->preco = $request->preco;
        $corte->save();

        return redirect()->route('home');
    }

    public function deleteCorte($id)
    {
        $corteId = Operations::decryptId($id);
        $corte = Corte::find($corteId);

        return view('delete_corte', ['corte' => $corte]);
    }

    public function deleteCorteConfirm($id)
    {
        $corteId = Operations::decryptId($id);
        $corte = Corte::find($corteId);

        if (!$corte) {
            return redirect()->route('home');
        }

        $corte->delete();

        return redirect()->route('home');
    }
}
