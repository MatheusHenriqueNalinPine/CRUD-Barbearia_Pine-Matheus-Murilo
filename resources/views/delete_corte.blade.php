@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card bg-dark text-light border-0 shadow-lg p-5 text-center rounded-4">
                <div class="mb-4">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10" style="width: 90px; height: 90px;">
                        <i class="fa-solid fa-triangle-exclamation text-danger fs-1"></i>
                    </span>
                </div>

                <h4 class="text-white mb-2">{{ $corte->nome_corte }}</h4>
                <p class="mb-4" style="color: #adb5bd;">Tem certeza que deseja excluir este corte permanentemente? Essa ação não poderá ser desfeita.</p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('lixeira') }}" class="btn btn-outline-light px-4 rounded-3">
                        <i class="fa-solid fa-xmark me-2"></i>Cancelar
                    </a>
                    <a href="{{ route('forceDelete', \App\Services\Operations::encryptId($corte->id)) }}" class="btn btn-danger px-4 rounded-3">
                        <i class="fa-solid fa-trash me-2"></i>Excluir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection