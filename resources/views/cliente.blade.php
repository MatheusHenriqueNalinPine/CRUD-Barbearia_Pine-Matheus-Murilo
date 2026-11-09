@php
    $isTrash = isset($isTrash) ? $isTrash : (method_exists($cliente, 'trashed') && $cliente->trashed());
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
@endphp

<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100 bg-dark text-light">
    <div class="p-4 flex-fill">
        <h2 class="h5 text-warning text-break mb-3">
            <i class="fa-solid fa-user me-2"></i>{{ $cliente->name }}
        </h2>
        
        @if($cliente->email)
        <p class="mb-2 text-secondary text-break">
            <strong class="text-light">E-mail:</strong> {{ $cliente->email }}
        </p>
        @endif

        @if($isTrash && $cliente->deleted_at)
        <p class="mb-0 text-muted small">
            <strong class="text-light">Excluído em:</strong> {{ $cliente->deleted_at->format('d/m/Y H:i') }}
        </p>
        @else
        <p class="mb-0 text-secondary small">
            <strong class="text-light">Cadastrado em:</strong> {{ $cliente->created_at->format('d/m/Y') }}
        </p>
        @endif
    </div>

    @if($isBarbeiro)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-3">
        @if($isTrash)
            <a href="{{ route('clientes.restore', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-success rounded-2">
                <i class="fa-solid fa-rotate-left me-1"></i>Restaurar
            </a>
            <a href="{{ route('clientes.delete.confirm', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
                <i class="fa-regular fa-trash-can me-1"></i>Excluir Permanente
            </a>
        @else
            <a href="{{ route('clientes.edit', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
                <i class="fa-regular fa-pen-to-square me-1"></i>Editar
            </a>
            <a href="{{ route('clientes.destroy', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
                <i class="fa-regular fa-trash-can me-1"></i>Remover
            </a>
        @endif
    </div>
    @endif
</div>