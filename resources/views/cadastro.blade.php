@extends('layouts.main_layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">
                    <div class="text-center p-3 mb-3">
                        <img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" style="max-width: 210px; height: auto; filter: drop-shadow(0 0 18px rgba(8, 8, 8, 0.25));">
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="{{ route('cadastro.submit') }}" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuário</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-info">
                                        </span>
                                        <input type="text" class="form-control bg-dark text-info" name="username" value="{{ old('username') }}" maxlength="50">
                                    </div>
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-info">
                                        </span>
                                        <input type="email" class="form-control bg-dark text-info" name="email" value="{{ old('email') }}" maxlength="255">
                                    </div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-info">
                                        </span>
                                        <input type="password" class="form-control bg-dark text-info" name="password" maxlength="20">
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark text-info">
                                        </span>
                                        <input type="password" class="form-control bg-dark text-info" name="password_confirmation" maxlength="20">
                                    </div>
                                </div>

                                <div class="mb-3 mt-4">
                                    <button type="submit" class="btn btn-secondary w-100">
                                        <i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp;CADASTRAR
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-decoration-none" style="color: #f39c12;">Já possui conta? Faça login</a>
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-secondary mt-3">
                        <small>&copy;Copyright <?= date('Y') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
