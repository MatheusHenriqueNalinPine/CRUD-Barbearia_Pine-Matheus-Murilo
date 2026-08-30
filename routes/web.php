<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsLogged::class])->group(function () {
	Route::get('/', [MainController::class, 'index'])->name('home');
	Route::get('/new-corte', [MainController::class, 'newCorte'])->name('new');
	Route::post('/newCorteSubmit', [MainController::class, 'newCorteSubmit'])->name('newCorteSubmit');
	Route::get('/edit-corte/{id}', [MainController::class, 'editCorte'])->name('edit');
	Route::post('/edit-corte-submit', [MainController::class, 'editCorteSubmit'])->name('edit.corte.submit');
	Route::get('/delete-corte/{id}', [MainController::class, 'deleteCorte'])->name('delete');
	Route::get('/deleteCorteConfirm/{id}', [MainController::class, 'deleteCorteConfirm'])->name('deleteCorteConfirm');
	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
	Route::get('/login', [AuthController::class, 'login'])->name('login');
	Route::get('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro');
	Route::post('/login-submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
	Route::post('/cadastro-submit', [AuthController::class, 'cadastroSubmit'])->name('cadastro.submit');
});
