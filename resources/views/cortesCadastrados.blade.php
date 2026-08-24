@extends('layouts.main_layout')

@section('title', 'Barbearia Pine | Seus cortes agendados')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-sm-11">
                <div class="card p-5">
                    <div class="text-center p-3 mb-4">
                        <img src="{{ asset('assets/images/icon.png') }}" alt="Barbearia Pine" style="max-width: 180px; height: auto;">
                        <h1 class="text-info h2 mt-3">Seus cortes agendados</h1>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    @forelse ($agendamentos as $agendamento)
                        <div class="border border-secondary border-opacity-25 rounded p-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <small class="text-secondary">Corte</small>
                                    <h2 class="h5 text-info mb-0">{{ $agendamento->nome_corte }}</h2>
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <small class="text-secondary">Horário</small>
                                    <p class="mb-0 text-light">{{ $agendamento->horario->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fa-solid fa-calendar-xmark text-warning fs-2 mb-3"></i>
                            <p class="text-secondary">Você não possui cortes agendados.</p>
                        </div>
                    @endforelse

                    <div class="row g-2 mt-3">
                        <div class="col-md-6">
                            <a href="{{ route('inicio') }}" class="btn btn-secondary w-100">
                                <i class="fa-solid fa-plus me-2"></i>Novo agendamento
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-outline-light w-100">
                                <i class="fa-solid fa-house me-2"></i>Voltar para home
                            </a>
                        </div>
                    </div>

                    <div class="text-center text-secondary mt-4">
                        <small>&copy;Copyright <?= date('Y') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection