@extends('layouts.main_layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="row">
                <div class="col">
                    <p class="display-6 mb-0">NOVO CORTE</p>
                </div>
                <div class="col text-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>
            <!-- form -->
            <form action="{{ route('newCorteSubmit') }}" method="post">
                @csrf
                <div class="row mt-3">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Nome do Corte</label>
                            <input type="text" class="form-control bg-primary text-white" name="nome_corte" value="{{ old('nome_corte') }}">
                            @error('nome_corte')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preço</label>
                            <input type="number" step="0.01" min="0" class="form-control bg-primary text-white" name="preco" value="{{ old('preco') }}">
                            @error('preco')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-primary px-5"><i class="fa-solid fa-ban me-2"></i>Cancelar</a>
                        <button type="submit" class="btn btn-secondary px-5"><i class="fa-regular fa-circle-check me-2"></i>Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection