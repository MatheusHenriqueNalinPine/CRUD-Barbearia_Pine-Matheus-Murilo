<div class="mb-3">
    <label class="form-label" for="barbeiro_id">Barbeiro</label>
    <select id="barbeiro_id" class="form-select bg-black text-light border-secondary" name="barbeiro_id" required>
        <option value="">Selecione um profissional</option>
        @foreach($barbeiros as $barbeiro)
        <option value="{{ \App\Services\Operations::encryptId($barbeiro->id) }}" @selected((string) old('barbeiro_id', isset($agendamento) ? \App\Services\Operations::encryptId($agendamento->barbeiro_id) : '') === (string) \App\Services\Operations::encryptId($barbeiro->id))>
            {{ $barbeiro->name ?? $barbeiro->username }}
        </option>
        @endforeach
    </select>
    @error('barbeiro_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="corte_id">Corte</label>
    <select id="corte_id" class="form-select bg-black text-light border-secondary" name="corte_id" required>
        <option value="">Selecione um estilo de corte</option>
        @foreach($cortes as $corte)
        <option value="{{ \App\Services\Operations::encryptId($corte->id) }}" @selected((string) old('corte_id', isset($agendamento) ? \App\Services\Operations::encryptId($agendamento->corte_id) : '') === (string) \App\Services\Operations::encryptId($corte->id))>
            {{ $corte->nome }} - R$ {{ number_format($corte->preco, 2, ',', '.') }}
        </option>
        @endforeach
    </select>
    @error('corte_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="data_hora">Data e Horário</label>
    <input id="data_hora" type="datetime-local" class="form-control bg-black text-light border-secondary" name="data_hora" value="{{ old('data_hora', isset($agendamento) ? $agendamento->data_hora : '') }}" required>
    @error('data_hora')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>