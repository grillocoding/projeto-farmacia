 
@extends('layouts.app')

@section('title', 'Pedido Confirmado')

@section('content')
<div class="max-w-lg mx-auto text-center mt-10">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-10">
        
        <div class="text-6xl mb-4">🎉</div>
        
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">
            Pedido Realizado!
        </h1>
        
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
            Seu pedido foi recebido com sucesso e está sendo processado.
        </p>

        <div class="bg-teal-50 dark:bg-teal-900 border border-teal-200 dark:border-teal-700 rounded-xl p-4 mb-6">
            <p class="text-teal-700 dark:text-teal-300 text-sm font-medium">
                ✅ Pagamento aprovado com sucesso!
            </p>
        </div>

        <a href="{{ route('medicamentos.index') }}"
           class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg text-sm font-semibold transition">
            Continuar Comprando
        </a>

    </div>

</div>
@endsection