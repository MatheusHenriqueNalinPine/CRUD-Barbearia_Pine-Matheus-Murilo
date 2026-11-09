@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-dark text-light border-0 shadow-lg rounded-4 p-4 p-md-5">
                <h2 class="h3 text-white mb-4">Editar agendamento</h2>

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('agendamentos.edit', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}" method="post">
                    @csrf

                    {{-- Barbeiro --}}
                    <div class="mb-3">
                        <label for="barbeiro_id" class="form-label">Barbeiro</label>
                        <select name="barbeiro_id" id="barbeiro_id" class="form-select bg-dark text-light border-secondary">
                            @foreach($barbeiros as $barbeiro)
                                <option value="{{ \App\Services\Operations::encryptId($barbeiro->id) }}" @selected($agendamento->barbeiro_id == $barbeiro->id)>
                                    {{ $barbeiro->name ?? $barbeiro->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Corte --}}
                    <div class="mb-3">
                        <label for="corte_id" class="form-label">Corte</label>
                        <select name="corte_id" id="corte_id" class="form-select bg-dark text-light border-secondary">
                            @foreach($cortes as $corte)
                                <option value="{{ \App\Services\Operations::encryptId($corte->id) }}" @selected($agendamento->corte_id == $corte->id)>
                                    {{ $corte->nome }} - R$ {{ number_format($corte->preco, 2, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Data e Hora --}}
                    <div class="mb-3">
                        <label for="data_hora" class="form-label">Data e Hora</label>
                        <input type="datetime-local" name="data_hora" id="data_hora" value="{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('Y-m-d\TH:i') }}" class="form-control bg-dark text-light border-secondary">
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select bg-dark text-light border-secondary">
                            <option value="pendente" @selected($agendamento->status == 'pendente')>Pendente</option>
                            <option value="confirmado" @selected($agendamento->status == 'confirmado')>Confirmado</option>
                            <option value="cancelado" @selected($agendamento->status == 'cancelado')>Cancelado</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('agendamentos.index') }}" class="btn btn-outline-light flex-fill rounded-3">
                            <i class="fa-solid fa-ban me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold flex-fill rounded-3">
                            <i class="fa-regular fa-circle-check me-2"></i>Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection