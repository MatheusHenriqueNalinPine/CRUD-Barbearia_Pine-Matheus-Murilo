<div class="mb-3">
    <label class="form-label" for="nome">Nome do produto</label>
    <input id="nome" type="text" class="form-control bg-black text-light border-secondary" name="nome" value="{{ old('nome', isset($produto) ? $produto->nome : '') }}" maxlength="100" required>
    @error('nome')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="descricao">Descrição</label>
    <textarea id="descricao" class="form-control bg-black text-light border-secondary" name="descricao" rows="3" maxlength="1000">{{ old('descricao', isset($produto) ? $produto->descricao : '') }}</textarea>
    @error('descricao')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="imagem">Imagem do produto</label>
    @if(isset($produto) && $produto->imagem)
    <div class="mb-2">
        <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="rounded-2" style="max-width: 180px; max-height: 120px; object-fit: cover;">
    </div>
    @endif
    <input id="imagem" type="file" class="form-control bg-black text-light border-secondary" name="imagem" accept="image/jpeg,image/png,image/gif,image/webp">
    @error('imagem')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="preco">Preço</label>
    <div class="input-group">
        <span class="input-group-text bg-black text-light border-secondary">R$</span>
        <input id="preco" type="number" step="0.01" min="0" class="form-control bg-black text-light border-secondary" name="preco" value="{{ old('preco', isset($produto) ? $produto->preco : '') }}" required>
    </div>
    @error('preco')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="quantidade">Quantidade em estoque</label>
    <input id="quantidade" type="number" min="0" max="1000000" class="form-control bg-black text-light border-secondary" name="quantidade" value="{{ old('quantidade', isset($produto) ? $produto->quantidade : 0) }}" required>
    @error('quantidade')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
