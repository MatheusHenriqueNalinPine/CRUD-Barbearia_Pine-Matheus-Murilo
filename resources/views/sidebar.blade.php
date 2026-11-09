@php
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
    $isCliente = $userLogado && $userLogado->role === 'cliente';
@endphp

<div class="bg-dark text-light p-3 d-flex flex-column" style="width: 220px; min-height: 100vh;">
    <div class="text-center mb-4">
        <img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" class="img-fluid mb-2" style="max-width: 120px;">
    </div>

    {{-- Exibe o botão "Novo agendamento" apenas na página de index e APENAS se NÃO for barbeiro (ou seja, se for cliente) --}}
    @if(request()->routeIs('agendamentos.index') && !$isBarbeiro)
        <a href="{{ route('agendamentos.create') }}" class="btn btn-warning fw-bold mb-2 text-start">
            <i class="fa-solid fa-plus me-2"></i>Novo agendamento
        </a>
    @endif

    @if(request()->routeIs('home'))
        @if($isBarbeiro)
            <a href="{{ route('new') }}" class="btn btn-warning fw-bold mb-2 text-start">
                <i class="fa-solid fa-scissors me-2"></i>Novo corte
            </a>
        @endif
    @endif

    @if(request()->routeIs('produtos.index'))
        @if($isBarbeiro)
            <a href="{{ route('produtos.create') }}" class="btn btn-warning fw-bold mb-2 text-start">
                <i class="fa-solid fa-plus me-2"></i>Novo produto
            </a>
        @endif
    @endif

    @if(request()->routeIs('fornecedores.index'))
        @if($isBarbeiro)
            <a href="{{ route('fornecedores.create') }}" class="btn btn-warning fw-bold mb-2 text-start">
                <i class="fa-solid fa-plus me-2"></i>Novo fornecedor
            </a>
        @endif
    @endif

    {{-- Links de Navegação Principais (Agendamentos em primeiro) --}}
    <a href="{{ route('agendamentos.index') }}" class="btn {{ request()->routeIs('agendamentos*') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
        <i class="fa-solid fa-calendar-days me-2"></i>Agendamentos
    </a>

    <a href="{{ route('home') }}" class="btn {{ request()->routeIs('home') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
        <i class="fa-solid fa-scissors me-2"></i>Cortes
    </a>

    <a href="{{ route('produtos.index') }}" class="btn {{ request()->routeIs('produtos*') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
        <i class="fa-solid fa-box-open me-2"></i>Produtos
    </a>

    @if($isBarbeiro)
        <a href="{{ route('fornecedores.index') }}" class="btn {{ request()->routeIs('fornecedores*') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
            <i class="fa-solid fa-truck-field me-2"></i>Fornecedores
        </a>
        <a href="{{ route('clientes.index') }}" class="btn {{ request()->routeIs('clientes*') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
            <i class="fa-solid fa-users me-2"></i>Clientes
        </a>
        <a href="{{ route('lixeira') }}" class="btn {{ request()->routeIs('lixeira') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 text-start">
            <i class="fa-solid fa-trash me-2"></i>Lixeira
        </a>
    @endif

    <div class="mt-auto">
        @if($isCliente)
            <a href="{{ route('carrinho.index') }}" class="btn {{ request()->routeIs('carrinho*') ? 'btn-light text-dark' : 'btn-outline-light' }} mb-2 w-100 text-start">
                <i class="fa-solid fa-cart-shopping me-2"></i>Carrinho
            </a>
        @endif

        <div class="text-center text-secondary small mb-2">
            <i class="fa-solid fa-user me-1"></i>{{ session('user')['username'] }}
        </div>
        <a href="{{ route('logout') }}" class="btn btn-danger w-100 text-start">
            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
        </a>
    </div>
</div>