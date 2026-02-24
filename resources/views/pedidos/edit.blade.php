@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Pedido #{{ $pedido->id }}</h1>

    <form action="{{ route('pedidos.update', $pedido) }}" method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
            <select name="status"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @foreach(['pendente', 'aprovado', 'enviado', 'entregue', 'cancelado'] as $status)
                    <option value="{{ $status }}" {{ $pedido->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Endereço de Entrega</label>
            <input type="text" name="endereco_entrega"
                   value="{{ old('endereco_entrega', $pedido->endereco_entrega) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Observação</label>
            <textarea name="observacao" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('observacao', $pedido->observacao) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-sm transition">
                Atualizar
            </button>
            <a href="{{ route('pedidos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection