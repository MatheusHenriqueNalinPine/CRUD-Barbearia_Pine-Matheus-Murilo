@extends('layouts.main_layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="top-bar mb-4 px-3 py-2 rounded d-flex justify-content-end align-items-center gap-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="text-light fw-bold text-end">
                        olá, {{ $user->username ?? 'Barbeiro' }}
                    </div>
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-danger">Logout</a>
                </div>

                @yield('page-content')
            </div>
        </div>
    </div>
@endsection
