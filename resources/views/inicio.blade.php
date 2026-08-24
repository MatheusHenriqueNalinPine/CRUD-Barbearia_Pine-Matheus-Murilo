@extends('layouts.main_layout')

@section('title', 'Barbearia Pine | Início')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-sm-11">
                <div class="card p-5">
                    <div class="text-center p-3 mb-3">
                    </div>

                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-9 col-12">
                            <form action="{{ route('inicio.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nome_corte" class="form-label">Nome do corte</label>
                                    <input type="text" id="nome_corte" name="nome_corte" class="form-control" value="{{ old('nome_corte') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="horario" class="form-label">Horário</label>
                                    <input type="datetime-local" id="horario" name="horario" class="form-control" value="{{ old('horario') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="barbeiro" class="form-label">Barbeiro</label>
                                    <select id="barbeiro" name="barbeiro" class="form-control">
                                        @foreach ($barbeiros as $barbeiro)
                                            <option value="{{ $barbeiro }}" @selected(old('barbeiro') === $barbeiro)>{{ $barbeiro }}</option>
                                        @endforeach
                                    </select>
                                    @error('barbeiro') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="fa-regular"></i>Salvar agendamento
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('cortes.cadastrados') }}" class="text-warning">Ver meus cortes agendados</a>
                    </div>

                    <div class="text-center text-secondary mt-4">
                        <small>Olá, {{ $user->name ?? 'cliente' }}! &copy;Copyright <?= date('Y') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection