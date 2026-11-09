<div class="mb-3">
    <label class="form-label" for="username">Nome de usuário</label>
    <input id="username" type="text" class="form-control bg-black text-light border-secondary" name="username" value="{{ old('username', isset($cliente) ? $cliente->username : '') }}" maxlength="100" required>
    @error('username')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="email">E-mail</label>
    <input id="email" type="email" class="form-control bg-black text-light border-secondary" name="email" value="{{ old('email', isset($cliente) ? $cliente->email : '') }}" maxlength="255" required>
    @error('email')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="password">
        Senha 
        @isset($cliente)
            <span class="text-muted small">(Deixe em branco para manter a atual)</span>
        @endisset
    </label>
    <input id="password" type="password" class="form-control bg-black text-light border-secondary" name="password" @isset($cliente) @else required @endisset minlength="6">
    @error('password')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="role">Cargo / Papel</label>
    <select name="role" id="role" class="form-select bg-black text-light border-secondary">
        <option value="cliente" @selected(old('role', isset($cliente) ? $cliente->role : '') === 'cliente')>Cliente</option>
        <option value="barbeiro" @selected(old('role', isset($cliente) ? $cliente->role : '') === 'barbeiro')>Barbeiro</option>
    </select>
    @error('role')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>