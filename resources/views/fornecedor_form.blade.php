<div class="mb-3">
    <label class="form-label" for="nome">Nome do fornecedor</label>
    <input id="nome" type="text" class="form-control bg-black text-light border-secondary" name="nome" value="{{ old('nome', isset($fornecedor) ? $fornecedor->nome : '') }}" maxlength="100" required>
    @error('nome')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="telefone">Telefone</label>
    <input id="telefone" type="text" class="form-control bg-black text-light border-secondary" name="telefone" value="{{ old('telefone', isset($fornecedor) ? $fornecedor->telefone : '') }}" maxlength="30">
    @error('telefone')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="email">E-mail</label>
    <input id="email" type="email" class="form-control bg-black text-light border-secondary" name="email" value="{{ old('email', isset($fornecedor) ? $fornecedor->email : '') }}" maxlength="255">
    @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="endereco">Endereço</label>
    <input id="endereco" type="text" class="form-control bg-black text-light border-secondary" name="endereco" value="{{ old('endereco', isset($fornecedor) ? $fornecedor->endereco : '') }}" maxlength="255">
    @error('endereco')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
