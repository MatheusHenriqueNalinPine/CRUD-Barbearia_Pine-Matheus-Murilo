<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="p-4">
        <h2 class="h5 text-white text-break">{{ $fornecedor->nome }}</h2>
        @if($fornecedor->telefone)
        <p class="mb-2 text-secondary"><strong>Telefone:</strong> {{ $fornecedor->telefone }}</p>
        @endif
        @if($fornecedor->email)
        <p class="mb-0 text-secondary text-break"><strong>E-mail:</strong> {{ $fornecedor->email }}</p>
        @endif
    </div>
    <div class="d-flex justify-content-end gap-2 p-3 pt-0">
        <a href="{{ route('fornecedores.restore', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-success rounded-2">
            <i class="fa-solid fa-clock-rotate-left me-1"></i>Recuperar
        </a>
        <a href="{{ route('fornecedores.delete.confirm', ['id' => \App\Services\Operations::encryptId($fornecedor->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Deletar
        </a>
    </div>
</div>
