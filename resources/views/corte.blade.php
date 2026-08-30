<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="d-flex align-items-center p-2">
        <div style="width: 150px; height: 150px; flex-shrink: 0;">
            @if($corte->imagem)
                <img src="{{ asset('storage/' . $corte->imagem) }}" alt="{{ $corte->nome_corte }}" class="w-100 h-100 object-fit-cover rounded-2">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-secondary rounded-2" style="font-size: 2.5rem;">
                    <i class="fa-solid fa-scissors"></i>
                </div>
            @endif
        </div>

        <div class="p-4 flex-fill">
            <p class="mb-2 text-white fs-5 text-nowrap"><strong>Nome:</strong> {{ $corte->nome_corte }}</p>
            <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Preço:</strong> R$ {{ number_format($corte->preco, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 p-3 pt-0">
        <a href="{{ route('edit', ['id' => \App\Services\Operations::encryptId($corte->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('delete', ['id' => \App\Services\Operations::encryptId($corte->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Remover
        </a>
    </div>
</div>