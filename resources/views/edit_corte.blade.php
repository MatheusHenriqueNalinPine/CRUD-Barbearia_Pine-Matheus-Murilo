@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <div class="row">
                <div class="col">
                    <p class="display-6 mb-0">EDITAR CORTE</p>
                </div>
                <div class="col text-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>

            <form action="{{ route('edit.corte.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="corte_id" value="{{ \App\Services\Operations::encryptId($corte->id) }}">

                <div class="row mt-3">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Nome do Corte</label>
                            <input type="text" class="form-control bg-primary text-white" name="nome_corte" value="{{ old('nome_corte', $corte->nome_corte) }}">
                            @error('nome_corte')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Horário</label>
                            <input type="time" class="form-control bg-primary text-white" name="horario" value="{{ old('horario', $corte->horario ? substr($corte->horario, 0, 5) : '') }}">
                            @error('horario')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagem do corte</label>
                            @if($corte->imagem)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $corte->imagem) }}" alt="{{ $corte->nome_corte }}" style="max-width: 180px; max-height: 120px; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" class="form-control bg-primary text-white" name="imagem" accept="image/jpeg,image/png,image/gif,image/webp">
                            @error('imagem')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preço</label>
                            <div class="input-group price-input">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" min="0" class="form-control bg-primary text-white" name="preco" placeholder="0,00" value="{{ old('preco', $corte->preco) }}">
                            </div>
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
