@extends('layouts.topbar_layout')

@section('page-content')
	<div class="home-content px-3 px-md-5 py-3">
		<div class="text-center p-3 mb-3">
			<img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" style="max-width: 210px; height: auto; filter: drop-shadow(0 0 18px rgba(5, 5, 5, 0.25));">
		</div>

		<div class="row justify-content-center text-center">
			<div class="col-12">
				<h1 class="text-info mb-3">Bem-vindo barbeiro</h1>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-8 col-12">
				<a href="{{ route('new') }}" class="btn btn-secondary w-100 mb-2">
					<i class="fa-regular"></i>Cadastrar horário dos cortes agendados
				</a>
			</div>
		</div>

		<div class="mt-4">
			<h2 class="text-info mb-3">Cortes cadastrados</h2>

			@if($cortes->isEmpty())
				<div class="alert alert-secondary text-center text-dark">
					Nenhum corte cadastrado ainda.
				</div>
			@else
				<div class="list-group">
					@foreach($cortes as $corte)
						<div class="corte-card list-group-item d-flex justify-content-between align-items-center bg-dark text-light border-secondary mb-2 rounded gap-3">
							<div>
								@if($corte->imagem)
									<img src="{{ asset('storage/' . $corte->imagem) }}" alt="{{ $corte->nome_corte }}" class="corte-card-image me-2">
								@endif
								<strong>{{ $corte->nome_corte }}</strong>
								<div class="text-secondary">Horário: {{ substr($corte->horario, 0, 5) }}</div>
							</div>
							<div class="text-end d-flex align-items-center gap-2">
								<span class="badge bg-secondary text-dark">R$ {{ number_format($corte->preco, 2, ',', '.') }}</span>
								<a href="{{ route('edit', ['id' => \App\Services\Operations::encryptId($corte->id)]) }}" class="btn btn-sm btn-warning text-dark">Editar</a>
								<a href="{{ route('delete', ['id' => \App\Services\Operations::encryptId($corte->id)]) }}" class="btn btn-sm btn-danger">Excluir</a>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>

		<div class="text-center text-secondary mt-4">
			<small>&copy;Copyright <?= date('Y') ?></small>
		</div>
	</div>
@endsection