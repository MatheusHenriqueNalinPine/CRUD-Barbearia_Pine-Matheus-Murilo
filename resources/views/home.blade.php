@extends('layouts.main_layout')

@section('content')
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-10 col-lg-8 col-sm-11">
				<div class="card p-5">
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
							<a href="{{ route('logout') }}" class="btn btn-secondary w-100">
								<i class="fa-regular"></i>Logout
							</a>
						</div>
					</div>

					<div class="text-center text-secondary mt-4">
						<small>&copy;Copyright <?= date('Y') ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection