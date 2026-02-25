@extends('layouts.app')

@section('title', 'Novo Pedido')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Pedido</h1>

    <form action="{{ route('pedidos.store') }}" method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        {{-- Cliente --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cliente *</label>
            <select name="user_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                    @error('user_id') border-red-400 @enderror">
                <option value="">Selecione um cliente</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} — {{ $user->email }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Itens do pedido --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-700">Medicamentos *</label>
                <button type="button" onclick="adicionarItem()"
                        class="text-xs bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded transition">
                    + Adicionar Item
                </button>
            </div>

            <div id="itens" class="space-y-3">
                {{-- Item inicial --}}
                <div class="item-linha grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-7">
                        <label class="text-xs text-gray-500">Medicamento</label>
                        <select name="items[0][medicamento_id]"
                                class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                            <option value="">Selecione</option>
                            @foreach($medicamentos as $med)
                                <option value="{{ $med->id }}">
                                    {{ $med->nome }} — R$ {{ number_format($med->preco, 2, ',', '.') }} ({{ $med->estoque }} em estoque)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <label class="text-xs text-gray-500">Quantidade</label>
                        <input type="number" name="items[0][quantidade]" min="1" value="1"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                    <div class="col-span-2">
                        <button type="button" onclick="removerItem(this)"
                                class="w-full bg-red-100 hover:bg-red-200 text-red-600 py-2 rounded text-xs transition">
                            Remover
                        </button>
                    </div>
                </div>
            </div>

            @error('items') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Endereço e observação --}}
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço de Entrega</label>
                <input type="text" name="endereco_entrega" value="{{ old('endereco_entrega') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Observação</label>
                <textarea name="observacao" rows="2"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">{{ old('observacao') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-500 text-white px-5 py-2 rounded text-sm transition">
                Criar Pedido
            </button>
            <a href="{{ route('pedidos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>

<script>
    let index = 1;
    const medicamentosOptions = `@foreach($medicamentos as $med)<option value="{{ $med->id }}">{{ $med->nome }} — R$ {{ number_format($med->preco, 2, ',', '.') }} ({{ $med->estoque }} em estoque)</option>@endforeach`;

    function adicionarItem() {
        const container = document.getElementById('itens');
        const div = document.createElement('div');
        div.classList.add('item-linha', 'grid', 'grid-cols-12', 'gap-2', 'items-end');
        div.innerHTML = `
            <div class="col-span-7">
                <label class="text-xs text-gray-500">Medicamento</label>
                <select name="items[${index}][medicamento_id]"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <option value="">Selecione</option>
                    ${medicamentosOptions}
                </select>
            </div>
            <div class="col-span-3">
                <label class="text-xs text-gray-500">Quantidade</label>
                <input type="number" name="items[${index}][quantidade]" min="1" value="1"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>
            <div class="col-span-2">
                <button type="button" onclick="removerItem(this)"
                        class="w-full bg-red-100 hover:bg-red-200 text-red-600 py-2 rounded text-xs transition">
                    Remover
                </button>
            </div>
        `;
        container.appendChild(div);
        index++;
    }

    function removerItem(btn) {
        const linhas = document.querySelectorAll('.item-linha');
        if (linhas.length > 1) {
            btn.closest('.item-linha').remove();
        }
    }
</script>
@endsection