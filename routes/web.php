<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

    // Todos logados podem ver medicamentos
    Route::get('/medicamentos', [MedicamentoController::class, 'index'])->name('medicamentos.index');

    // Somente admin
    Route::middleware('admin')->group(function () {
        Route::get('/medicamentos/create', [MedicamentoController::class, 'create'])->name('medicamentos.create');
        Route::post('/medicamentos', [MedicamentoController::class, 'store'])->name('medicamentos.store');
        Route::get('/medicamentos/{medicamento}/edit', [MedicamentoController::class, 'edit'])->name('medicamentos.edit');
        Route::put('/medicamentos/{medicamento}', [MedicamentoController::class, 'update'])->name('medicamentos.update');
        Route::delete('/medicamentos/{medicamento}', [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');
        Route::resource('pedidos', PedidoController::class);
        Route::resource('users', UserController::class);
    });

    // Show depois do grupo admin para não conflitar com /create
    Route::get('/medicamentos/{medicamento}', [MedicamentoController::class, 'show'])->name('medicamentos.show');
});

