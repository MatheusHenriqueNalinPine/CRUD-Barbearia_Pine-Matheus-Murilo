@extends('layouts.main_layout')

@section('content')
@php
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
@endphp

<div class="d-flex" style="min-height: 100vh;">
    
    @include('sidebar')

    <div class="flex-fill p-4 bg-black text-light">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="h3 mb-0">Cortes</h1>

            <form method="GET" action="{{ route('home') }}" class="d-flex align-items-center gap-2" style="max-width: 500px; width: 100%;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-dark text-light border-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control bg-dark text-light border-0"
                        placeholder="Pesquisar corte"
                    >
                    <button class="btn btn-warning fw-bold" type="submit">Buscar</button>
                </div>

                @if(request('search'))
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="fa-solid fa-rotate-left me-1"></i>Voltar
                </a>
                @endif
            </form>
        </div>

        @if($cortes->total() === 0)
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">
                    @if(request('search'))
                        Nenhum corte "{{ request('search') }}" encontrado
                    @else
                        A barbearia não possui cortes cadastrados
                    @endif
                </p>
            </div>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach ($cortes as $corte)
            <div class="col">
                @include('corte')
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <form method="GET" action="{{ route('home') }}" class="d-flex align-items-center gap-2">
                @if($search !== '')
                <input type="hidden" name="search" value="{{ $search }}">
                @endif
                <label for="cortes-order" class="text-nowrap">Ordenar:</label>
                <select id="cortes-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                @if($isBarbeiro)
                <a href="{{ route('cortes.pdf', array_filter(['search' => $search, 'order' => $order === 'oldest' ? 'oldest' : 'recent'])) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                <a href="{{ route('cortes.excel', array_filter(['search' => $search, 'order' => $order === 'oldest' ? 'oldest' : 'recent'])) }}" class="btn btn-outline-success">
                    <i class="fa-solid fa-file-excel me-1"></i>Gerar Excel
                </a>
                @endif
                {{ $cortes->links() }}
            </div>
        </div>
        @endif

    </div>
</div>
@endsection