@extends('layouts.main_layout')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    
    @include('sidebar')

    <div class="flex-fill p-4 bg-black text-light">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="h3 mb-0">Fornecedores</h1>

            <form method="GET" action="{{ route('fornecedores.index') }}" class="d-flex align-items-center gap-2" style="max-width: 500px; width: 100%;">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-dark text-light border-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" class="form-control bg-dark text-light border-0" placeholder="Pesquisar fornecedor">
                    <button class="btn btn-warning fw-bold" type="submit">Buscar</button>
                </div>
                @if($search !== '')
                <a href="{{ route('fornecedores.index') }}" class="btn btn-outline-light btn-sm fw-bold">
                    <i class="fa-solid fa-rotate-left me-1"></i>Voltar
                </a>
                @endif
            </form>
        </div>

        @if($fornecedores->total() === 0)
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">
                    @if($search !== '')
                        Nenhum fornecedor "{{ $search }}" encontrado
                    @else
                        A barbearia não possui fornecedores cadastrados
                    @endif
                </p>
            </div>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            @foreach($fornecedores as $fornecedor)
            <div class="col">
                @include('fornecedor')
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <form method="GET" action="{{ route('fornecedores.index') }}" class="d-flex align-items-center gap-2">
                @if($search !== '')
                <input type="hidden" name="search" value="{{ $search }}">
                @endif
                <label for="fornecedores-order" class="text-nowrap">Ordenar:</label>
                <select id="fornecedores-order" name="order" class="form-select bg-dark text-light border-secondary">
                    <option value="recent" @selected($order === 'recent')>Mais recentes</option>
                    <option value="oldest" @selected($order === 'oldest')>Mais antigos</option>
                </select>
                <button class="btn btn-warning fw-bold" type="submit">Aplicar</button>
            </form>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('fornecedores.pdf', array_filter(['search' => $search, 'order' => $order])) }}" class="btn btn-outline-danger">
                    <i class="fa-solid fa-file-pdf me-1"></i>Gerar PDF
                </a>
                {{ $fornecedores->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection