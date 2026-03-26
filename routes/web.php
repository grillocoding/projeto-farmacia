<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// 🔓 LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// 🔓 REGISTER
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// 🔑 RECUPERAÇÃO DE SENHA
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// 🔒 ROTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('logout');

    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('users', UserController::class);
});