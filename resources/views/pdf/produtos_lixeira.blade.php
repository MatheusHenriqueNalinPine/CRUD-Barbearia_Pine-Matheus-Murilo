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
    <h1>Produtos na lixeira</h1>
    <div class="subtitle">{{ $produtos->count() }} {{ $produtos->count() === 1 ? 'produto' : 'produtos' }} · Gerado em {{ now()->format('d/m/Y H:i') }}</div>
    <table>
        <thead><tr><th>Produto</th><th>Descrição</th><th class="number">Preço</th><th class="number">Estoque</th><th>Excluído em</th></tr></thead>
        <tbody>
            @forelse($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->descricao ?? '—' }}</td>
                <td class="number">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td class="number">{{ $produto->quantidade }}</td>
                <td>{{ $produto->deleted_at?->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5">Nenhum produto na lixeira.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
