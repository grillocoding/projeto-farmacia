<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('medicamentos', MedicamentoController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('users', UserController::class);