@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card p-5 text-center">
                <span class="display-3 mb-5"><i class="fa-solid fa-triangle-exclamation text-warning opacity-50"></i></span>
                <h4 class="text-info mb-3">{{ $corte->nome_corte }}</h4>
                <p class="text-secondary">Confirma a exclusão deste corte?</p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-primary px-5 m-2"><i class="fa-solid fa-xmark me-2"></i>Não</a>
                    <a href="{{ route('deleteCorteConfirm', \App\Services\Operations::encryptId($corte->id)) }}" class="btn btn-danger px-5 m-2"><i class="fa-solid fa-trash me-2"></i>Sim</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
