<div class="mb-3">
    <label class="form-label" for="nome">Nome do cliente</label>
    <input id="nome" type="text" class="form-control bg-black text-light border-secondary" name="nome" value="{{ old('nome', isset($cliente) ? $cliente->nome : '') }}" maxlength="100" required>
    @error('nome')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="tipo_cabelo">Tipo de cabelo</label>
    <select id="tipo_cabelo" class="form-select bg-black text-light border-secondary" name="tipo_cabelo" required>
        <option value="">Selecione o tipo de cabelo</option>
        @foreach($tiposCabelo as $valor => $rotulo)
        <option value="{{ $valor }}" @selected(old('tipo_cabelo', isset($cliente) ? $cliente->tipo_cabelo : '') === $valor)>{{ $rotulo }}</option>
        @endforeach
    </select>
    @error('tipo_cabelo')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="corte_favorito_id">Corte favorito</label>
    <select id="corte_favorito_id" class="form-select bg-black text-light border-secondary" name="corte_favorito_id">
        <option value="">Sem corte favorito</option>
        @foreach($cortes as $corte)
        <option value="{{ $corte->id }}" @selected((string) old('corte_favorito_id', isset($cliente) ? $cliente->corte_favorito_id : '') === (string) $corte->id)>
            {{ $corte->nome_corte }}
        </option>
        @endforeach
    </select>
    @error('corte_favorito_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
