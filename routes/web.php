<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas públicas
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/2fa/verify', [AuthController::class, 'showVerify'])->name('2fa.verify');
Route::post('/2fa/verify', [AuthController::class, 'verify'])->name('2fa.verify.post');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    
    Route::get('/perfil', [AuthController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [AuthController::class, 'atualizarPerfil'])->name('perfil.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/2fa/toggle', [AuthController::class, 'toggleTwoFactor'])->name('2fa.toggle');
    
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('users', UserController::class);
});



Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

