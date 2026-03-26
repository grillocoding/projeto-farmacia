@extends('layouts.app')

@section('title', 'Pagamento')

@section('content')
<div class="max-w-2xl mx-auto">

    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">💳 Finalizar Pagamento</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Resumo do pedido --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-4">Resumo do Pedido</h2>
            @foreach($carrinho->items as $item)
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-700 dark:text-gray-300">{{ $item->medicamento->nome }} x{{ $item->quantidade }}</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="border-t border-gray-100 dark:border-gray-700 pt-3 mt-3 flex justify-between font-bold">
                <span>Total</span>
                <span>R$ {{ number_format($carrinho->total, 2, ',', '.') }}</span>
            </div>
        </div>

        {{-- Formulário de pagamento --}}
        <form action="{{ route('carrinho.finalizar') }}" method="POST">
            @csrf
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                <h2 class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-4">Dados do Cartão</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome no Cartão</label>
                    <input type="text" placeholder="Ex: João Silva" required
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número do Cartão</label>
                    <input type="text" placeholder="0000 0000 0000 0000" maxlength="19" required
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Validade</label>
                        <input type="text" placeholder="MM/AA" maxlength="5" required
                               class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CVV</label>
                        <input type="text" placeholder="000" maxlength="3" required
                               class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Endereço de Entrega</label>
                    <input type="text" name="endereco_entrega" placeholder="Rua, número, bairro..." required
                           value="{{ Auth::user()->address }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <button type="submit"
                        class="w-full bg-teal-500 hover:bg-teal-600 text-white py-3 rounded-lg text-sm font-bold transition shadow-sm">
                    💳 Pagar R$ {{ number_format($carrinho->total, 2, ',', '.') }}
                </button>

                <a href="{{ route('medicamentos.index') }}"
                   class="block text-center text-sm text-gray-400 hover:text-gray-600 mt-2">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection