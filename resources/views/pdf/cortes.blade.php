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
    <h1>Lista de cortes</h1>
    <div class="subtitle">
        @if($search !== '')
            Busca: "{{ $search }}" ·
        @endif
        {{ $cortes->count() }} {{ $cortes->count() === 1 ? 'corte' : 'cortes' }} ·
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome do corte</th>
                <th class="price">Preço</th>
                <th>Cadastrado em</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cortes as $corte)
            <tr>
                <td>{{ $corte->nome_corte }}</td>
                <td class="price">R$ {{ number_format($corte->preco, 2, ',', '.') }}</td>
                <td>{{ $corte->created_at?->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Nenhum corte encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
