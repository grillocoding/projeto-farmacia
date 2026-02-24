@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Pedido #{{ $pedido->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('pedidos.edit', $pedido) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm transition">
                Editar
            </a>
            <a href="{{ route('pedidos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm transition">
                Voltar
            </a>
        </div>
    </div>

    {{-- Informações gerais --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-sm font-semibold text-gray-500 uppercase mb-4">Informações</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Cliente</p>
                <p class="font-medium text-gray-800">{{ $pedido->user->name }}</p>
                <p class="text-gray-400 text-xs">{{ $pedido->user->email }}</p>
            </div>
            <div>
                <p class="text-gray-500">Status</p>
                @php
                    $cores = [
                        'pendente'  => 'bg-yellow-100 text-yellow-700',
                        'aprovado'  => 'bg-blue-100 text-blue-700',
                        'enviado'   => 'bg-purple-100 text-purple-700',
                        'entregue'  => 'bg-green-100 text-green-700',
                        'cancelado' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold {{ $cores[$pedido->status] }}">
                    {{ ucfirst($pedido->status) }}
                </span>
            </div>
            <div>
                <p class="text-gray-500">Endereço de Entrega</p>
                <p class="font-medium text-gray-800">{{ $pedido->endereco_entrega ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Data do Pedido</p>
                <p class="font-medium text-gray-800">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($pedido->observacao)
            <div class="col-span-2">
                <p class="text-gray-500">Observação</p>
                <p class="font-medium text-gray-800">{{ $pedido->observacao }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Itens do pedido --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-500 uppercase">Itens do Pedido</h2>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Medicamento</th>
                    <th class="px-6 py-3 text-center">Qtd</th>
                    <th class="px-6 py-3 text-right">Preço Unit.</th>
                    <th class="px-6 py-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pedido->items as $item)
                <tr>
                    <td class="px-6 py-3 font-medium text-gray-800">
                        {{ $item->medicamento->nome }}
                        <span class="text-xs text-gray-400 ml-1">{{ $item->medicamento->dosagem }}</span>
                    </td>
                    <td class="px-6 py-3 text-center text-gray-600">{{ $item->quantidade }}</td>
                    <td class="px-6 py-3 text-right text-gray-600">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right font-medium text-gray-800">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-6 py-3 text-right font-semibold text-gray-700">Total</td>
                    <td class="px-6 py-3 text-right font-bold text-green-700 text-base">
                        R$ {{ number_format($pedido->total, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
@endsection