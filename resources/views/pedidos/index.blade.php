@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
    <a href="{{ route('pedidos.create') }}"
       class="bg-teal-500 hover:bg-teal-500 text-white px-4 py-2 rounded shadow text-sm transition">
        + Novo Pedido
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-teal-500 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Cliente</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Data</th>
                <th class="px-4 py-3">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pedidos as $pedido)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-500">{{ $pedido->id }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $pedido->user->name }}</td>
                <td class="px-4 py-3">
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
                </td>
                <td class="px-4 py-3 text-gray-600">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('pedidos.show', $pedido) }}"
                       class="text-blue-600 hover:underline text-xs">Ver</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}"
                       class="text-yellow-600 hover:underline text-xs">Editar</a>
                    @if($pedido->isCancelado())
                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST"
                          onsubmit="return confirm('Excluir pedido?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-xs">Excluir</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">Nenhum pedido encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $pedidos->links() }}
</div>
@endsection