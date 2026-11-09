@php
    $isTrash = isset($isTrash) ? $isTrash : (method_exists($produto, 'trashed') && $produto->trashed());
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
    $isCliente = $userLogado && $userLogado->role === 'cliente';
@endphp

<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100 bg-dark text-light d-flex flex-column">
    <div class="d-flex align-items-center p-2">
        <div style="width: 120px; height: 120px; flex-shrink: 0;">
            @if($produto->imagem)
                <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="w-100 h-100 object-fit-cover rounded-2">
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-black text-secondary rounded-2" style="font-size: 2.5rem;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
            @endif
        </div>

        <div class="p-3 flex-fill min-w-0">
            <p class="mb-2 text-white fs-5 text-break"><strong>{{ $produto->nome }}</strong></p>
            
            @if($isBarbeiro && isset($produto->user))
                <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Cadastrado por:</strong> {{ $produto->user->name ?? $produto->user->username }}</p>
            @endif

            <p class="mb-1 text-nowrap" style="color: #adb5bd;"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
            <p class="mb-0 text-nowrap" style="color: #adb5bd;"><strong>Estoque:</strong> {{ $produto->quantidade }}</p>
            <p class="mb-0 text-break" style="color: #adb5bd;"><strong>Fornecedor:</strong> {{ $produto->fornecedor?->nome ?? 'Não informado' }}</p>

            @if($isTrash && $produto->deleted_at)
                <p class="mb-0 mt-1 small" style="color: #adb5bd;"><strong>Excluído em:</strong> {{ $produto->deleted_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
    </div>

    @if($produto->descricao && !$isTrash)
    <p class="px-3 mb-3 text-secondary">{{ $produto->descricao }}</p>
    @endif

    @if($isBarbeiro)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-2">
        @if($isTrash)
            <a href="{{ route('produtos.restore', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-success rounded-2">
                <i class="fa-solid fa-rotate-left me-1"></i>Restaurar
            </a>
            <a href="{{ route('produtos.delete.confirm', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
                <i class="fa-regular fa-trash-can me-1"></i>Excluir Permanente
            </a>
        @else
            <form action="{{ route('produtos.stock.adjust', ['operacao' => 'aumentar']) }}" method="POST">
                @csrf
                <input type="hidden" name="produto_id" value="{{ \App\Services\Operations::encryptId($produto->id) }}">
                <button type="submit" class="btn btn-sm btn-outline-success rounded-2" aria-label="Aumentar estoque de {{ $produto->nome }}" title="Aumentar estoque" @disabled($produto->quantidade >= 1000000)>
                    <i class="fa-solid fa-plus"></i>
                </button>
            </form>
            <form action="{{ route('produtos.stock.adjust', ['operacao' => 'diminuir']) }}" method="POST">
                @csrf
                <input type="hidden" name="produto_id" value="{{ \App\Services\Operations::encryptId($produto->id) }}">
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
        @endif
    </div>
    @endif

    @if($isCliente && !$isTrash)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-2">
        @if($produto->quantidade > 0)
            <form action="{{ route('carrinho.adicionar', ['id' => \App\Services\Operations::encryptId($produto->id)]) }}" method="POST" class="w-100">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-warning w-100 rounded-2">
                    <i class="fa-solid fa-cart-plus me-1"></i> Adicionar ao Carrinho
                </button>
            </form>
        @else
            <div class="w-100 text-center py-1">
                <span class="text-danger fw-bold small">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Sem estoque
                </span>
            </div>
        @endif
    </div>
    @endif
</div>