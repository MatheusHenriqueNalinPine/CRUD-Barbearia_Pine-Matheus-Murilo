<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { color: #222; font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { margin-bottom: 4px; font-size: 20px; }
        .subtitle { margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 7px; border: 1px solid #ccc; text-align: left; }
        th { background: #eee; }
        .number { text-align: right; white-space: nowrap; }
    </style>
</head>
<body>
    <h1>Lista de fornecedores</h1>
    <div class="subtitle">
        @if($search !== '')
            Busca: "{{ $search }}" ·
        @endif
        {{ $fornecedores->count() }} {{ $fornecedores->count() === 1 ? 'fornecedor' : 'fornecedores' }} ·
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Fornecedor</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th class="number">Produtos cadastrados</th>
                <th>Cadastrado em</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fornecedores as $fornecedor)
            <tr>
                <td>{{ $fornecedor->nome }}</td>
                <td>{{ $fornecedor->email ?? '—' }}</td>
                <td>{{ $fornecedor->telefone ?? '—' }}</td>
                <td>{{ $fornecedor->endereco ?? '—' }}</td>
                <td class="number">{{ $fornecedor->produtos_count }}</td>
                <td>{{ $fornecedor->created_at?->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6">Nenhum fornecedor encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
