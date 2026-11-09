@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-dark text-light border-0 shadow-lg rounded-4 p-4 p-md-5">
                <h2 class="h3 text-warning mb-4">
                    <i class="fa-solid fa-user-pen me-2"></i>Editar cliente
                </h2>

                <form action="{{ route('clientes.update', ['id' => \App\Services\Operations::encryptId($cliente->id)]) }}" method="post">
                    @csrf
                    @include('cliente_form')

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('clientes.index') }}" class="btn btn-outline-light flex-fill rounded-3">
                            <i class="fa-solid fa-ban me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold flex-fill rounded-3">
                            <i class="fa-regular fa-circle-check me-2"></i>Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection