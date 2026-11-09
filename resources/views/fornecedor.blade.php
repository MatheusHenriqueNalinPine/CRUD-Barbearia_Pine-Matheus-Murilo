@php
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
@endphp

<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100 bg-dark text-light">
    <div class="p-4 flex-fill">
        <h2 class="h5 text-white text-break">{{ $fornecedor->nome }}</h2>

        {{-- Cadastrado por padronizado com a mesma cor e tamanho --}}
        @if($isBarbeiro && isset($fornecedor->user))
            <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Cadastrado por:</strong> {{ $fornecedor->user->name ?? $fornecedor->user->username }}</p>
        @endif

        <p class="mb-2" style="color: #adb5bd;"><strong>Produtos:</strong> {{ $fornecedor->produtos_count }}</p>
        
        @if($fornecedor->telefone)
        <p class="mb-2 text-break" style="color: #adb5bd;"><strong>Telefone:</strong> {{ $fornecedor->telefone }}</p>
        @endif
        
        @if($fornecedor->email)
        <p class="mb-2 text-break" style="color: #adb5bd;"><strong>E-mail:</strong> {{ $fornecedor->email }}</p>
        @endif
        
        @if($fornecedor->endereco)
        <p class="mb-0 text-break" style="color: #adb5bd;"><strong>Endereço:</strong> {{ $fornecedor->endereco }}</p>
        @endif
    </div>

    @if($isBarbeiro)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-2">
        <a href="{{ route('fornecedores.edit', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('fornecedores.destroy', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Remover
        </a>
    </div>
    @endif
</div>