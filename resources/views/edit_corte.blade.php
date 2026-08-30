@extends('layouts.main_layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-dark text-light border-0 shadow-lg rounded-4 p-4 p-md-5">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-white mb-0">Edit Corte</h2>
                </div>

                <form action="{{ route('edit.corte.submit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="corte_id" value="{{ \App\Services\Operations::encryptId($corte->id) }}">

                    <div class="mb-3">
                        <label class="form-label" style="color: #adb5bd;">Nome do Corte</label>
                        <input type="text" class="form-control bg-black text-light border-secondary" name="nome_corte" value="{{ old('nome_corte', $corte->nome_corte) }}">
                        @error('nome_corte')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: #adb5bd;">Imagem do Corte</label>
                        @if($corte->imagem)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $corte->imagem) }}" alt="{{ $corte->nome_corte }}" class="rounded-2" style="max-width: 180px; max-height: 120px; object-fit: cover;">
                        </div>
                        @endif
                        <input type="file" class="form-control bg-black text-light border-secondary" name="imagem" accept="image/jpeg,image/png,image/gif,image/webp">
                        @error('imagem')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="color: #adb5bd;">Preço</label>
                        <div class="input-group">
                            <span class="input-group-text bg-black text-light border-secondary">R$</span>
                            <input type="number" step="0.01" min="0" class="form-control bg-black text-light border-secondary" name="preco" placeholder="0,00" value="{{ old('preco', $corte->preco) }}">
                        </div>
                        @error('preco')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-light flex-fill rounded-3">
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