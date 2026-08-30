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

    public function cadastro()
    {
        return view('cadastro');
    }

    public function cadastroSubmit(Request $request)
    {
        $request->validate(
            [
                'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
            ],
            [
                'username.required' => 'O campo usuário é obrigatório.',
                'username.string' => 'O usuário deve conter apenas texto válido.',
                'username.min' => 'O usuário deve ter no mínimo 3 caracteres.',
                'username.max' => 'O usuário deve ter no máximo 50 caracteres.',
                'username.unique' => 'Este usuário já está em uso.',

                'email.required' => 'O campo e-mail é obrigatório.',
                'email.email' => 'Digite um endereço de e-mail válido.',
                'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
                'email.unique' => 'Este e-mail já está cadastrado.',

                'password.required' => 'O campo senha é obrigatório.',
                'password.string' => 'A senha deve conter apenas texto válido.',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
                'password.max' => 'A senha deve ter no máximo 20 caracteres.',
                'password.confirmed' => 'A confirmação da senha não confere.',
            ]
        );

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return redirect()->route('login')->with('cadastro_success', 'Cadastro realizado com sucesso! Faça login para continuar.');
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
                'username' => $user->username,
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