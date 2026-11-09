<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { color: #222; font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { margin-bottom: 4px; font-size: 20px; }
        .subtitle { margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Lista de clientes</h1>
    <div class="subtitle">
        @if($search !== '')
            Busca: "{{ $search }}" ·
        @endif
        {{ $clientes->count() }} {{ $clientes->count() === 1 ? 'cliente' : 'clientes' }} ·
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>
    <table>
        <thead><tr><th>Nome</th><th>Tipo de cabelo</th><th>Cadastrado em</th></tr></thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nome }}</td>
                <td>{{ \App\Models\Cliente::TIPOS_CABELO[$cliente->tipo_cabelo] }}</td>
                <td>{{ $cliente->created_at?->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="3">Nenhum cliente encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
