<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarrinhoController;
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

    Route::get('/perfil', [AuthController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [AuthController::class, 'atualizarPerfil'])->name('perfil.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/2fa/toggle', [AuthController::class, 'toggleTwoFactor'])->name('2fa.toggle');

    // Todos logados podem ver medicamentos
    Route::get('/medicamentos', [MedicamentoController::class, 'index'])->name('medicamentos.index');

    // Rotas do carrinho
    Route::get('/carrinho/pagamento', [CarrinhoController::class, 'pagamento'])->name('carrinho.pagamento');
    Route::get('/carrinho/confirmacao', [CarrinhoController::class, 'confirmacao'])->name('carrinho.confirmacao');
    Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');
    Route::post('/carrinho/{medicamento}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::delete('/carrinho/{item}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');

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