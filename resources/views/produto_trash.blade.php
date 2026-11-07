<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="d-flex align-items-center p-2">
        <div style="width: 150px; height: 150px; flex-shrink: 0;">
            @if($produto->imagem)
                <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="w-100 h-100 object-fit-cover rounded-2">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-secondary rounded-2" style="font-size: 2.5rem;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            @endif
        </div>

        <div class="p-4 flex-fill">
            <p class="mb-2 text-white fs-5 text-break"><strong>{{ $produto->nome }}</strong></p>
            <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p class="mb-0 text-nowrap" style="color: #adb5bd;"><strong>Estoque:</strong> {{ $produto->quantidade }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 p-3 pt-0">
        <a href="{{ route('produtos.restore', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-success rounded-2">
            <i class="fa-solid fa-clock-rotate-left me-1"></i>Recuperar
        </a>
        <a href="{{ route('produtos.delete.confirm', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Deletar
        </a>
    </div>
</div>
