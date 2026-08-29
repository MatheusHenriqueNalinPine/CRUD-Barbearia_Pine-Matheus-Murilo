<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'max:20'],
            ],  
            [
                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Digite um endereço de e-mail válido.',
                'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',

                'password.required' => 'O campo senha é obrigatório.',
                'password.string' => 'A senha deve conter apenas texto válido.',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
                'password.max' => 'A senha deve ter no máximo 20 caracteres.',
            ]
        );

        $email = $request->input('email');
        $senha = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('login_error', 'E-mail ou senha incorretos!');
        }

        if (!password_verify($senha, $user->password)) {
            return redirect()->back()
                ->withInput()
                ->with('login_error', 'E-mail ou senha incorretos!');
        }

        session([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ]
        ]);

        return redirect()->route('home');
    }

     public function create(){
        return 'Criando usuario';
    }

     public function logout(){
        session()->forget('user');

       return redirect()->route('login');
    }
}