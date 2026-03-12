@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Pedidos</h1>
    <a href="{{ route('pedidos.create') }}"
       class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Novo Pedido
    </a>
</div>

<form method="GET" action="{{ route('pedidos.index') }}" class="mb-4 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Buscar por ID ou nome do cliente..."
           class="flex-1 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
           focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-sm">
    <button type="submit"
            class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        🔍 Buscar
    </button>
    @if(request('search'))
        <a href="{{ route('pedidos.index') }}"
           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg text-sm transition">
            ✕
        </a>
    @endif
</form>

@if($pedidos->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 py-12 text-center">
        <p class="text-4xl mb-3">🛒</p>
        <p class="text-gray-400 dark:text-gray-500 text-sm">Nenhum pedido encontrado.</p>
        <a href="{{ route('pedidos.create') }}" class="mt-3 inline-block text-teal-500 hover:underline text-sm">
            Criar primeiro pedido
        </a>
    </div>
@else
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-teal-500 dark:bg-teal-700 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">🛒</th>
                <th class="px-4 py-3">Cliente</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Data</th>
                <th class="px-4 py-3">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @foreach($pedidos as $pedido)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                <td class="px-4 py-3">
                    <span class="bg-teal-50 dark:bg-teal-900 text-teal-600 dark:text-teal-300 border border-teal-200 dark:border-teal-700 px-2 py-1 rounded-lg text-xs font-bold">
                        #{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </td>

                <td class="px-4 py-3">
                    <span class="font-semibold text-gray-800 dark:text-gray-100 text-xs">{{ $pedido->user->name }}</span>
                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $pedido->user->email }}</p>
                </td>

                <td class="px-4 py-3">
                    @php
                        $badges = [
                            'pendente'  => ['bg-yellow-100 text-yellow-700 border-yellow-200',  '🕐 Pendente'],
                            'aprovado'  => ['bg-blue-100 text-blue-700 border-blue-200',        '✅ Aprovado'],
                            'enviado'   => ['bg-purple-100 text-purple-700 border-purple-200',  '🚚 Enviado'],
                            'entregue'  => ['bg-green-100 text-green-700 border-green-200',     '📦 Entregue'],
                            'cancelado' => ['bg-red-100 text-red-700 border-red-200',           '❌ Cancelado'],
                        ];
                        [$classe, $label] = $badges[$pedido->status];
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-bold border {{ $classe }}">
                        {{ $label }}
                    </span>
                </td>

                <td class="px-4 py-3">
                    <span class="text-xs text-gray-400 dark:text-gray-500">R$</span>
                    <span class="font-bold text-gray-800 dark:text-gray-100">{{ number_format(floor($pedido->total), 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">,{{ substr(number_format($pedido->total, 2), -2) }}</span>
                </td>

                <td class="px-4 py-3">
                    <span class="text-xs text-gray-700 dark:text-gray-300">{{ $pedido->created_at->format('d/m/Y') }}</span>
                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $pedido->created_at->format('H:i') }}</p>
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center gap-1">
                        <a href="{{ route('pedidos.show', $pedido) }}"
                           class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900 hover:bg-blue-100 text-blue-600 dark:text-blue-300 rounded-lg text-xs font-medium transition">
                            👁 Ver
                        </a>
                        <a href="{{ route('pedidos.edit', $pedido) }}"
                           class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-50 dark:bg-yellow-900 hover:bg-yellow-100 text-yellow-600 dark:text-yellow-300 rounded-lg text-xs font-medium transition">
                            ✏️ Editar
                        </a>
                        @if($pedido->isCancelado())
                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST"
                              onsubmit="return confirm('Excluir pedido #{{ $pedido->id }}?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 dark:bg-red-900 hover:bg-red-100 text-red-600 dark:text-red-300 rounded-lg text-xs font-medium transition">
                                🗑️
                            </button>
                        </form>
                        @endif
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $pedidos->links() }}
</div>
@endif

@endsection