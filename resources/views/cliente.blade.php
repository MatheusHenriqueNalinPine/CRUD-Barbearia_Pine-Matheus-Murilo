<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100">
    <div class="p-4 flex-fill">
        <h2 class="h5 text-white text-break">{{ $cliente->nome }}</h2>
        <p class="mb-2 text-secondary"><strong>Tipo de cabelo:</strong> {{ \App\Models\Cliente::TIPOS_CABELO[$cliente->tipo_cabelo] }}</p>
        <p class="mb-0 text-secondary"><strong>Corte favorito:</strong> {{ $cliente->corteFavorito?->nome_corte ?? 'Não informado' }}</p>
    </div>
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto">
        <a href="{{ route('clientes.edit', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('clientes.destroy', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Remover
        </a>
    </div>
</div>
