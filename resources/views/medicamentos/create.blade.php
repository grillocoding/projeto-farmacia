@extends('layouts.app')

@section('title', 'Novo Medicamento')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Medicamento</h1>

    <form action="{{ route('medicamentos.store') }}" method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text" name="nome" value="{{ old('nome') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('nome') border-red-400 @enderror">
                @error('nome') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Princípio Ativo *</label>
                <input type="text" name="principio_ativo" value="{{ old('principio_ativo') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('principio_ativo') border-red-400 @enderror">
                @error('principio_ativo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fabricante *</label>
                <input type="text" name="fabricante" value="{{ old('fabricante') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('fabricante') border-red-400 @enderror">
                @error('fabricante') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoria *</label>
                <input type="text" name="categoria" value="{{ old('categoria') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('categoria') border-red-400 @enderror">
                @error('categoria') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Preço *</label>
                <input type="number" name="preco" step="0.01" value="{{ old('preco') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('preco') border-red-400 @enderror">
                @error('preco') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estoque *</label>
                <input type="number" name="estoque" value="{{ old('estoque', 0) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('estoque') border-red-400 @enderror">
                @error('estoque') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dosagem</label>
                <input type="text" name="dosagem" value="{{ old('dosagem') }}" placeholder="ex: 500mg"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Validade</label>
                <input type="date" name="validade" value="{{ old('validade') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('validade') border-red-400 @enderror">
                @error('validade') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="requer_receita" id="requer_receita" value="1"
                   {{ old('requer_receita') ? 'checked' : '' }}
                   class="w-4 h-4 text-green-600">
            <label for="requer_receita" class="text-sm text-gray-700">Requer receita médica</label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
            <textarea name="descricao" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">{{ old('descricao') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-500 text-white px-5 py-2 rounded text-sm transition">
                Salvar
            </button>
            <a href="{{ route('medicamentos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection