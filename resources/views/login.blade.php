@extends('layouts.main_layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">
                    <div class="text-center p-3 mb-3">
                        <img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" style="max-width: 210px; height: auto; filter: drop-shadow(0 0 18px rgba(8, 8, 8, 0.25));">
                        <p class="mt-3 mb-0" style="color: #d9b654;">Mantenha sua agenda em dia !</p>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                                @csrf
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
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control bg-dark text-info" name="password" value="{{ old('password') }}" maxlength="20">
                                        <button type="button" class="input-group-text password-toggle" aria-label="Mostrar senha" aria-controls="password" aria-pressed="false">
                                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 mt-4">
                                    <button type="submit" class="btn btn-secondary w-100">
                                         <i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;LOGIN
                                    </button>
                                </div>
                            </form>

                            @if(session('login_error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('login_error') }}
                                </div>
                            @endif

                            @if(session('cadastro_success'))
                                <div class="alert alert-success text-center mt-3">
                                    {{ session('cadastro_success') }}
                                </div>
                            @endif

                            <div class="text-center mt-3">
                                <a href="{{ route('cadastro') }}" class="text-decoration-none" style="color: #f39c12;">Cadastre-se aqui</a>
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
    <script>
        document.querySelector('.password-toggle')?.addEventListener('click', function () {
            const password = document.getElementById(this.getAttribute('aria-controls'));
            const isVisible = password.type === 'text';

            password.type = isVisible ? 'password' : 'text';
            this.setAttribute('aria-label', isVisible ? 'Mostrar senha' : 'Ocultar senha');
            this.setAttribute('aria-pressed', String(!isVisible));
            this.querySelector('i').className = `fa-solid ${isVisible ? 'fa-eye' : 'fa-eye-slash'}`;
        });
    </script>
    <style>
        #password::-ms-reveal,
        #password::-ms-clear {
            display: none;
        }

        .password-toggle {
            color: #fff !important;
            cursor: pointer;
        }

        .password-toggle:hover,
        .password-toggle:focus {
            color: #fff !important;
            background: #101010 !important;
        }
    </style>
@endsection