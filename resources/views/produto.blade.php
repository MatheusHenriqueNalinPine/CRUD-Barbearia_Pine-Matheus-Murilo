<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100">
    <div class="d-flex align-items-center p-2">
        <div style="width: 120px; height: 120px; flex-shrink: 0;">
            @if($produto->imagem)
                <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="w-100 h-100 object-fit-cover rounded-2">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-secondary rounded-2" style="font-size: 2.5rem;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            @endif
        </div>

        <div class="p-3 flex-fill min-w-0">
            <p class="mb-2 text-white fs-5 text-break"><strong>{{ $produto->nome }}</strong></p>
            <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p class="mb-0 text-nowrap" style="color: #adb5bd;"><strong>Estoque:</strong> {{ $produto->quantidade }}</p>
        </div>
    </div>

    @if($produto->descricao)
    <p class="px-3 mb-3 text-secondary">{{ $produto->descricao }}</p>
    @endif

    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto">
        <form action="{{ route('produtos.stock.adjust', ['id' => \App\Services\Operations::encryptId($produto->id), 'operacao' => 'aumentar']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-success rounded-2" aria-label="Aumentar estoque de {{ $produto->nome }}" title="Aumentar estoque" @disabled($produto->quantidade >= 1000000)>
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>
        <form action="{{ route('produtos.stock.adjust', ['id' => \App\Services\Operations::encryptId($produto->id), 'operacao' => 'diminuir']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" aria-label="Diminuir estoque de {{ $produto->nome }}" title="Diminuir estoque" @disabled($produto->quantidade === 0)>
                <i class="fa-solid fa-minus"></i>
            </button>
        </form>
        <a href="{{ route('produtos.edit', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('produtos.destroy', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Remover
        </a>
    </div>
</div>
