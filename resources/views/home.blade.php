@extends('layouts.main_layout')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
	<div class="bg-dark text-light p-3 d-flex flex-column" style="width: 220px; min-height: 100vh;">
		<div class="text-center mb-4">
			<img src="{{ asset('assets/images/icon.png') }}" alt="BarbeariaPine" class="img-fluid mb-2" style="max-width: 120px;">
		</div>

		<a href="{{ route('new') }}" class="btn btn-warning fw-bold mb-2 text-start">
			<i class="fa-solid fa-scissors me-2"></i>Novo corte
		</a>

		<a href="{{ route('lixeira') }}" class="btn btn-outline-light mb-2 text-start">
			<i class="fa-solid fa-trash me-2"></i>Lixeira
		</a>

		<div class="mt-auto">
			<div class="text-center text-secondary small mb-2">
				<i class="fa-solid fa-user me-1"></i>{{ session('user')['username'] }}
			</div>
			<a href="{{ route('logout') }}" class="btn btn-danger w-100 text-start">
				<i class="fa-solid fa-right-from-bracket me-2"></i>Logout
			</a>
		</div>
	</div>

	<div class="flex-fill p-4 bg-black text-light">

		<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
			<h1 class="h3 mb-0">Registros de Cortes</h1>

			<div class="input-group" style="max-width: 400px;">
				<span class="input-group-text bg-dark text-light border-0">
					<i class="fa-solid fa-magnifying-glass"></i>
				</span>
				<input type="text" class="form-control bg-dark text-light border-0" placeholder="Search">
			</div>
		</div>

		@if(count($cortes) === 0)
		<div class="row mt-5">
			<div class="col text-center">
				<p class="display-6 mb-5 text-secondary opacity-50">Você não possui cortes cadastrados</p>
			</div>
		</div>
		@else
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
			@foreach ($cortes as $corte)
			<div class="col">
				@include('corte')
			</div>
			@endforeach
		</div>
		@endif

	</div>
</div>
@endsection