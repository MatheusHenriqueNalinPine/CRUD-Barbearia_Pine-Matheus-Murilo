@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-dark text-light border-0 shadow-lg rounded-4 p-4 p-md-5">
                <h1 class="h3 text-warning mb-4">
                    <i class="fa-solid fa-user-pen me-2"></i>Meus dados
                </h1>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('perfil.update') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="username">Nome de usuário</label>
                        <input id="username" type="text" class="form-control bg-black text-light border-secondary" name="username" value="{{ old('username', $user->username) }}" maxlength="50" autocomplete="username" required>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">E-mail</label>
                        <input id="email" type="email" class="form-control bg-black text-light border-secondary" name="email" value="{{ old('email', $user->email) }}" maxlength="255" autocomplete="email" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Nova senha <span class="text-secondary small">(opcional)</span></label>
                        <input id="password" type="password" class="form-control bg-black text-light border-secondary" name="password" minlength="6" maxlength="20" autocomplete="new-password">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirme a nova senha</label>
                        <input id="password_confirmation" type="password" class="form-control bg-black text-light border-secondary" name="password_confirmation" minlength="6" maxlength="20" autocomplete="new-password">
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-light flex-fill">
                            <i class="fa-solid fa-arrow-left me-2"></i>Voltar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold flex-fill">
                            <i class="fa-regular fa-circle-check me-2"></i>Salvar alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
