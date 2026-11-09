<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = User::find(session('user.id'));

        if (!$user) {
            session()->forget('user');

            return redirect()->route('login')->with('login_error', 'Sua conta não foi encontrada. Faça login novamente.');
        }

        return view('perfil', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find(session('user.id'));

        if (!$user) {
            session()->forget('user');

            return redirect()->route('login')->with('login_error', 'Sua conta não foi encontrada. Faça login novamente.');
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6', 'max:20', 'confirmed'],
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        session()->put('user.username', $user->username);
        session()->put('user.email', $user->email);

        return redirect()->route('perfil.edit')->with('success', 'Seus dados foram atualizados com sucesso.');
    }
}
