@extends('layouts.main_layout')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    
    @include('sidebar')

    <div class="flex-fill p-4 bg-black text-light">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="h3 mb-0">Lixeira</h1>
        </div>

        @if($cortes->total() === 0 && $produtos->total() === 0 && $fornecedores->total() === 0 && $clientes->total() === 0)
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">Você não possui itens na lixeira</p>
            </div>
        </div>
        @else
        
        {{-- Cortes na Lixeira --}}
        @if($cortes->total() > 0)
        <h2 class="h5 mb-3">Cortes</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-3">
            @foreach ($cortes as $corte)
            <div class="col">
                @include('corte', ['isTrash' => true])
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <form method="GET" action="{{ route('lixeira') }}" class="d-flex align-items-center gap-2">
                <label for="trash-cortes-order" class="text-nowrap">Ordenar:</label>
                <select id="trash-cortes-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('lixeira.cortes.pdf', ['order' => $order]) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $cortes->links() }}
            </div>
        </div>
        @endif

        {{-- Produtos na Lixeira --}}
        @if($produtos->total() > 0)
        <h2 class="h5 mb-3">Produtos</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-3">
            @foreach ($produtos as $produto)
            <div class="col">
                @include('produto', ['isTrash' => true])
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <form method="GET" action="{{ route('lixeira') }}" class="d-flex align-items-center gap-2">
                <label for="trash-produtos-order" class="text-nowrap">Ordenar:</label>
                <select id="trash-produtos-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('lixeira.produtos.pdf', ['order' => $order]) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $produtos->links() }}
            </div>
        </div>
        @endif

        {{-- Fornecedores na Lixeira --}}
        @if($fornecedores->total() > 0)
        <h2 class="h5 mb-3">Fornecedores</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-3">
            @foreach ($fornecedores as $fornecedor)
            <div class="col">
                @include('fornecedor', ['isTrash' => true])
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <form method="GET" action="{{ route('lixeira') }}" class="d-flex align-items-center gap-2">
                <label for="trash-fornecedores-order" class="text-nowrap">Ordenar:</label>
                <select id="trash-fornecedores-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('lixeira.fornecedores.pdf', ['order' => $order]) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $fornecedores->links() }}
            </div>
        </div>
        @endif

        {{-- Clientes na Lixeira --}}
        @if($clientes->total() > 0)
        <h2 class="h5 mb-3">Clientes</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-3">
            @foreach ($clientes as $cliente)
            <div class="col">
                @include('cliente', ['isTrash' => true])
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <form method="GET" action="{{ route('lixeira') }}" class="d-flex align-items-center gap-2">
                <label for="trash-clientes-order" class="text-nowrap">Ordenar:</label>
                <select id="trash-clientes-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('lixeira.clientes.pdf', ['order' => $order]) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $clientes->links() }}
            </div>
        </div>
        @endif
        @endif

    </div>
</div>
@endsection