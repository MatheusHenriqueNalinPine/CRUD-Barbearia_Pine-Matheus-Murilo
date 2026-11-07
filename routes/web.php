<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProdutoController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/cortes/pdf', [MainController::class, 'exportPdf'])->name('cortes.pdf');
    Route::get('/lixeira/cortes/pdf', [MainController::class, 'exportTrashedCutsPdf'])->name('lixeira.cortes.pdf');
    Route::get('/lixeira/produtos/pdf', [MainController::class, 'exportTrashedProductsPdf'])->name('lixeira.produtos.pdf');
    Route::get('/lixeira/fornecedores/pdf', [MainController::class, 'exportTrashedSuppliersPdf'])->name('lixeira.fornecedores.pdf');
    Route::get('/new-corte', [MainController::class, 'newCorte'])->name('new');
    Route::post('/newCorteSubmit', [MainController::class, 'newCorteSubmit'])->name('newCorteSubmit');
    Route::get('/edit-corte/{id}', [MainController::class, 'editCorte'])->name('edit');
    Route::post('/edit-corte-submit', [MainController::class, 'editCorteSubmit'])->name('edit.corte.submit');
    Route::get('/lixeira', [MainController::class, 'lixeira'])->name('lixeira');
    Route::get('/delete-corte/{id}', [MainController::class, 'deleteCorte'])->name('delete');
    Route::get('/delete-corte-confirm/{id}', [MainController::class, 'deleteCorteConfirm'])->name('delete.confirm');
    Route::get('/force-delete-corte/{id}', [MainController::class, 'forceDeleteCorte'])->name('forceDelete');
    Route::get('/restore-corte/{id}', [MainController::class, 'restoreCorte'])->name('restore');
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/pdf', [ProdutoController::class, 'exportPdf'])->name('produtos.pdf');
    Route::get('/new-produto', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/new-produto', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/edit-produto/{id}', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::post('/edit-produto/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::post('/produto/{id}/estoque/{operacao}', [ProdutoController::class, 'adjustStock'])->name('produtos.stock.adjust');
    Route::get('/delete-produto/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    Route::get('/restore-produto/{id}', [ProdutoController::class, 'restore'])->name('produtos.restore');
    Route::get('/delete-produto-confirm/{id}', [ProdutoController::class, 'confirmForceDelete'])->name('produtos.delete.confirm');
    Route::get('/force-delete-produto/{id}', [ProdutoController::class, 'forceDelete'])->name('produtos.force-delete');
    Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');
    Route::get('/fornecedores/pdf', [FornecedorController::class, 'exportPdf'])->name('fornecedores.pdf');
    Route::get('/new-fornecedor', [FornecedorController::class, 'create'])->name('fornecedores.create');
    Route::post('/new-fornecedor', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/edit-fornecedor/{id}', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::post('/edit-fornecedor/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    Route::get('/delete-fornecedor/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');
    Route::get('/restore-fornecedor/{id}', [FornecedorController::class, 'restore'])->name('fornecedores.restore');
    Route::get('/delete-fornecedor-confirm/{id}', [FornecedorController::class, 'confirmForceDelete'])->name('fornecedores.delete.confirm');
    Route::get('/force-delete-fornecedor/{id}', [FornecedorController::class, 'forceDelete'])->name('fornecedores.force-delete');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro');
    Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
    Route::post('/cadastro-submit', [AuthController::class, 'cadastroSubmit'])->name('cadastro.submit');
});