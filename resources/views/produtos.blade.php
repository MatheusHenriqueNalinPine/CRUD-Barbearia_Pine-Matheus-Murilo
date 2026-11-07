@extends('layouts.main_layout')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    <div class="bg-dark text-light p-3 d-flex flex-column" style="width: 220px; min-height: 100vh;">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" class="img-fluid mb-2" style="max-width: 120px;">
        </div>

        <a href="{{ route('home') }}" class="btn btn-outline-light mb-2 text-start">
            <i class="fa-solid fa-scissors me-2"></i>Cortes
        </a>
        <a href="{{ route('produtos.create') }}" class="btn btn-warning fw-bold mb-2 text-start">
            <i class="fa-solid fa-plus me-2"></i>Novo produto
        </a>
        <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-light mb-2 text-start">
            <i class="fa-solid fa-truck-field me-2"></i>Fornecedores
        </a>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-light mb-2 text-start">
            <i class="fa-solid fa-users me-2"></i>Clientes
        </a>
        <a href="{{ route('lixeira') }}" class="btn btn-outline-light mb-2 text-start">
            <i class="fa-solid fa-trash me-2"></i>Lixeira
        </a>

        <div class="mt-auto">
            <div class="text-center text-secondary small mb-2">
                <i class="fa-solid fa-user me-1"></i>{{ session('user')['username'] }}
            </div>
            <a href="{{ route('logout') }}" class="btn btn-danger w-100 text-start">
                <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
            </a>
        </div>
    </div>

    <div class="flex-fill p-4 bg-black text-light">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="h3 mb-0">Produtos</h1>

            <form method="GET" action="{{ route('produtos.index') }}" class="d-flex align-items-center gap-2" style="max-width: 500px; width: 100%;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-dark text-light border-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" class="form-control bg-dark text-light border-0" placeholder="Pesquisar produto">
                    <button class="btn btn-warning fw-bold" type="submit">Buscar</button>
                </div>
                @if($search !== '')
                <a href="{{ route('produtos.index') }}" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="fa-solid fa-rotate-left me-1"></i>Voltar
                </a>
                @endif
            </form>
        </div>

        @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif

        @if($produtos->total() === 0)
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">
                    @if($search !== '')
                        Nenhum produto "{{ $search }}" encontrado
                    @else
                        Você não possui produtos cadastrados
                    @endif
                </p>
            </div>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach($produtos as $produto)
            <div class="col">
                @include('produto')
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <form method="GET" action="{{ route('produtos.index') }}" class="d-flex align-items-center gap-2">
                @if($search !== '')
                <input type="hidden" name="search" value="{{ $search }}">
                @endif
                <label for="produtos-order" class="text-nowrap">Ordenar:</label>
                <select id="produtos-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('produtos.pdf', array_filter(['search' => $search, 'order' => $order])) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $produtos->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
