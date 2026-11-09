@extends('layouts.main_layout')

@section('content')
@php
$userLogado = \App\Models\User::find(session('user')['id']);
$isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';

$carrinho = $carrinho ?? session()->get('carrinho', []);
$totalGeral = 0;
@endphp

<div class="d-flex" style="min-height: 100vh;">

    @include('sidebar')

    <div class="flex-fill p-4 bg-black text-light">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="h3 mb-0">Carrinho de Compras</h1>

            <a href="{{ route('produtos.index') }}" class="btn btn-outline-light btn-sm fw-bold">
                <i class="fa-solid fa-arrow-left me-1"></i>Continuar Comprando
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger bg-dark text-danger border-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(empty($carrinho) || count($carrinho) === 0)
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-4 text-secondary opacity-50">
                    <i class="fa-solid fa-cart-shopping fa-2x mb-3 d-block"></i>
                    O seu carrinho está vazio
                </p>
                <a href="{{ route('produtos.index') }}" class="btn btn-warning fw-bold">Ver Produtos</a>
            </div>
        </div>
        @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-3">
                    @foreach($carrinho as $id => $item)
                    @php
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $totalGeral += $subtotal;
                    @endphp
                    <div class="card shadow-sm border-0 rounded-3 overflow-hidden bg-dark text-light">
                        <div class="d-flex align-items-center p-2">
                            <div style="width: 100px; height: 100px; flex-shrink: 0;">
                                @if(isset($item['imagem']) && $item['imagem'])
                                <img src="{{ asset('storage/' . $item['imagem']) }}" alt="{{ $item['nome'] }}" class="w-100 h-100 object-fit-cover rounded-2">
                                @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-black text-secondary rounded-2" style="font-size: 2rem;">
                                    <i class="fa-solid fa-box-open"></i>
                                </div>
                                @endif
                            </div>

                            <div class="p-3 flex-fill min-w-0">
                                <p class="mb-2 text-white fs-5 text-break"><strong>{{ $item['nome'] }}</strong></p>
                                <p class="mb-1" style="color: #adb5bd;"><strong>Preço Unit.:</strong> R$ {{ number_format($item['preco'], 2, ',', '.') }}</p>
                                <p class="mb-0" style="color: #adb5bd;"><strong>Quantidade:</strong> {{ $item['quantidade'] }}</p>
                            </div>

                            <div class="p-3 text-end">
                                <p class="mb-3 text-warning fw-bold fs-5">
                                    R$ {{ number_format($subtotal, 2, ',', '.') }}
                                </p>

                                <form action="{{ route('carrinho.remover', ['id' => \App\Services\Operations::encryptId($id)]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Remover item">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-dark text-light border-secondary shadow-sm rounded-3 p-4">
                    <h3 class="h5 mb-4 border-bottom border-secondary pb-3">Resumo do Pedido</h3>

                    <div class="d-flex justify-content-between mb-3" style="color: #adb5bd;">
                        <span>Subtotal</span>
                        <span>R$ {{ number_format($totalGeral, 2, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4 fs-5 fw-bold text-light border-top border-secondary pt-3">
                        <span>Total</span>
                        <span class="text-warning">R$ {{ number_format($totalGeral, 2, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('carrinho.finalizar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning fw-bold w-100 py-2">
                            <i class="fa-solid fa-check me-2"></i>Finalizar Compra
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection