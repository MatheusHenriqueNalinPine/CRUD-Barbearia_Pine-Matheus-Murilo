<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';

        $clientes = User::where('role', 'cliente')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
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

    public function create()
    {
        return view('new_cliente');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'cliente'; 
        $user->save();

        return redirect()->route('clientes.index');
    }

    public function edit($id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::find($decryptedId);

        if (!$cliente) {
            return redirect()->route('clientes.index');
        }

        return view('edit_cliente', ['cliente' => $cliente]); 
    }

    public function update(Request $request, $id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::find($decryptedId);

        if (!$cliente) {
            return redirect()->route('clientes.index');
        }

        $request->validate([
            'username' => 'required|min:3|max:100',
            'email' => 'email|unique:users,email,' . $cliente->id,
            'role' => 'required|in:cliente,barbeiro',
        ]);

        $cliente->username = $request->username;
        $cliente->email = $request->email;
        $cliente->role = $request->role;

        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }
        $cliente->save();

        return redirect()->route('clientes.index');
    }

    public function destroy($id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::find($decryptedId);

        if ($cliente) {
            $cliente->delete();
        }

        return redirect()->route('clientes.index');
    }

    public function restore($id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::onlyTrashed()->where('id', $decryptedId)->first();

        if ($cliente) {
            $cliente->restore();
        }

        return redirect()->route('lixeira');
    }

    public function confirmForceDelete($id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::onlyTrashed()->where('id', $decryptedId)->first();

        if (!$cliente) {
            return redirect()->route('lixeira');
        }

        return view('delete_cliente', ['cliente' => $cliente]);
    }

    public function forceDelete($id)
    {
        $decryptedId = Operations::decryptId($id);
        $cliente = User::onlyTrashed()->where('id', $decryptedId)->first();

        if ($cliente) {
            $cliente->forceDelete();
        }

        return redirect()->route('lixeira');
    }

    public function exportPdf(Request $request)
    {
        $order = $request->input('order') === 'oldest' ? 'asc' : 'desc';
        $clientes = User::where('role', 'cliente')
            ->orderBy('created_at', $order)
            ->get();

        return Pdf::loadView('pdf.clientes', ['clientes' => $clientes])
            ->setPaper('a4', 'portrait')
            ->download('lista-de-clientes.pdf');
    }
}