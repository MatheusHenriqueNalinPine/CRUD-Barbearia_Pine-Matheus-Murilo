<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100">
    <div class="p-4 flex-fill">
        <h2 class="h5 text-white text-break">{{ $fornecedor->nome }}</h2>
        <p class="mb-2 text-secondary"><strong>Produtos:</strong> {{ $fornecedor->produtos_count }}</p>
        @if($fornecedor->telefone)
        <p class="mb-2 text-secondary text-break"><strong>Telefone:</strong> {{ $fornecedor->telefone }}</p>
        @endif
        @if($fornecedor->email)
        <p class="mb-2 text-secondary text-break"><strong>E-mail:</strong> {{ $fornecedor->email }}</p>
        @endif
        @if($fornecedor->endereco)
        <p class="mb-0 text-secondary text-break"><strong>Endereço:</strong> {{ $fornecedor->endereco }}</p>
        @endif
    </div>

    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto">
        <a href="{{ route('fornecedores.edit', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('fornecedores.destroy', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Remover
        </a>
    </div>
</div>
