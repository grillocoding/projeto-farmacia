@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Medicamentos</h1>
    <a href="{{ route('medicamentos.create') }}"
       class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Novo Medicamento
    </a>
</div>

<form method="GET" action="{{ route('medicamentos.index') }}" class="mb-5 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Buscar por nome, categoria ou fabricante..."
           class="flex-1 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
           focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-sm">
    <button type="submit"
            class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        🔍 Buscar
    </button>
    @if(request('search'))
        <a href="{{ route('medicamentos.index') }}"
           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg text-sm transition">
            ✕
        </a>
    @endif
</form>

@if($medicamentos->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 py-16 text-center">
        <p class="text-4xl mb-3">💊</p>
        <p class="text-gray-400 dark:text-gray-500 text-sm">Nenhum medicamento cadastrado.</p>
        <a href="{{ route('medicamentos.create') }}" class="mt-3 inline-block text-teal-500 hover:underline text-sm">
            Cadastrar primeiro medicamento
        </a>
    </div>
@else
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
    @foreach($medicamentos as $medicamento)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md hover:-translate-y-0.5 transition-all relative flex flex-col items-center p-3 group">

        @if($medicamento->estoque === 0)
            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-md">
                Esgotado
            </span>
        @else
            <span class="absolute top-2 left-2 bg-teal-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-md">
                {{ $medicamento->estoque }} un.
            </span>
        @endif

        <div class="absolute top-2 right-2 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-all">
            <a href="{{ route('medicamentos.edit', $medicamento) }}"
               class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-yellow-50 hover:border-yellow-300 text-yellow-500 rounded-lg w-7 h-7 flex items-center justify-center shadow-sm text-xs"
               title="Editar">✏️</a>
            <form action="{{ route('medicamentos.destroy', $medicamento) }}" method="POST"
                  onsubmit="return confirm('Excluir {{ $medicamento->nome }}?')">
                @csrf @method('DELETE')
                <button class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:bg-red-50 hover:border-red-300 text-red-500 rounded-lg w-7 h-7 flex items-center justify-center shadow-sm text-xs"
                        title="Excluir">🗑️</button>
            </form>
        </div>

        <a href="{{ route('medicamentos.show', $medicamento) }}" class="w-full">
            <div class="w-full h-24 flex items-center justify-center my-2">
                @if($medicamento->imagem)
                    <img src="{{ asset('storage/' . $medicamento->imagem) }}"
                         alt="{{ $medicamento->nome }}"
                         class="h-full object-contain">
                @else
                    <span class="text-5xl">💊</span>
                @endif
            </div>
        </a>

        <div class="w-full text-center mt-1">
            <a href="{{ route('medicamentos.show', $medicamento) }}"
               class="text-xs font-semibold text-gray-700 dark:text-gray-200 hover:text-teal-600 transition leading-tight line-clamp-2 block mb-0.5">
                {{ $medicamento->nome }}
                @if($medicamento->dosagem)
                    <span class="text-gray-400 dark:text-gray-500">{{ $medicamento->dosagem }}</span>
                @endif
            </a>

            <p class="text-xs text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">{{ $medicamento->fabricante }}</p>

            @if($medicamento->requer_receita)
                <span class="text-xs bg-yellow-50 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-700 px-1.5 py-0.5 rounded-md mb-1 inline-block">
                    📋 Receita
                </span>
            @endif

            <div class="mt-1.5 pt-1.5 border-t border-gray-100 dark:border-gray-700">
                <span class="text-xs text-gray-400 dark:text-gray-500">R$</span>
                <span class="text-lg font-bold text-gray-800 dark:text-gray-100">
                    {{ number_format(floor($medicamento->preco), 0, ',', '.') }}
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">,{{ substr(number_format($medicamento->preco, 2), -2) }}</span>
            </div>
        </div>

    </div>
    @endforeach
</div>

<div class="mt-5">
    {{ $medicamentos->links() }}
</div>
@endif

@endsection