@php
    $userLogado = \App\Models\User::find(session('user')['id']);
    $isBarbeiro = $userLogado && $userLogado->role === 'barbeiro';
    $isCliente = $userLogado && $userLogado->role === 'cliente';
@endphp

<div class="card shadow-sm border-0 rounded-3 overflow-hidden h-100 bg-dark text-light d-flex flex-column">
    <div class="d-flex align-items-center p-3">
        <div class="flex-fill min-w-0">
            {{-- Exibe o nome do cliente se for barbeiro, ou o nome do barbeiro se for cliente --}}
            @if($isBarbeiro)
                <p class="mb-2 text-white fs-5 text-break"><strong>Cliente:</strong> {{ $agendamento->cliente->name ?? $agendamento->cliente->username ?? 'Não informado' }}</p>
            @else
                <p class="mb-2 text-white fs-5 text-break"><strong>Barbeiro:</strong> {{ $agendamento->barbeiro->name ?? $agendamento->barbeiro->username ?? 'Não informado' }}</p>
            @endif

            <p class="mb-1" style="color: #adb5bd;"><strong>Corte:</strong> {{ $agendamento->corte->nome ?? 'Não informado' }}</p>
            <p class="mb-1" style="color: #adb5bd;"><strong>Preço:</strong> R$ {{ number_format($agendamento->corte->preco ?? 0, 2, ',', '.') }}</p>
            <p class="mb-1" style="color: #adb5bd;"><strong>Data e Hora:</strong> {{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y H:i') }}</p>
            
            <p class="mb-0">
                <strong>Status:</strong> 
                <span class="badge {{ $agendamento->status == 'confirmado' ? 'bg-success' : ($agendamento->status == 'cancelado' ? 'bg-danger' : 'bg-warning text-dark') }}">
                    {{ ucfirst($agendamento->status) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Ações para Barbeiros --}}
    @if($isBarbeiro)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-2">
        <a href="{{ route('agendamentos.edit', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}" class="btn btn-sm btn-outline-secondary rounded-2">
            <i class="fa-regular fa-pen-to-square me-1"></i>Editar
        </a>
        <a href="{{ route('agendamentos.destroy', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}" class="btn btn-sm btn-outline-danger rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i>Cancelar
        </a>
    </div>
    @endif

    {{-- Ações para Clientes --}}
    @if($isCliente)
    <div class="d-flex justify-content-end gap-2 p-3 pt-0 mt-auto border-top border-secondary pt-2">
        <a href="{{ route('agendamentos.destroy', ['id' => \App\Services\Operations::encryptId($agendamento->id)]) }}" class="btn btn-sm btn-outline-danger w-100 rounded-2">
            <i class="fa-regular fa-trash-can me-1"></i> Cancelar Agendamento
        </a>
    </div>
    @endif
</div>