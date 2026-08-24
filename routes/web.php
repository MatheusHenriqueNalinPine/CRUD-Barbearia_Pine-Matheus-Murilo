<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('home');
})->name('home');

Route::get('/inicio', [MainController::class, 'index'])->name('inicio');
Route::post('/inicio', [MainController::class, 'store'])->name('inicio.store');
Route::get('/cortes-cadastrados', [MainController::class, 'cortesCadastrados'])->name('cortes.cadastrados');

Route::get('/home_page', function () {
	return redirect()->route('home');
})->name('home.page');

Route::get('/home', function () {
	return redirect()->route('home');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');