@extends('layouts.app')

@section('title', $medicamento->nome)

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $medicamento->nome }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('medicamentos.edit', $medicamento) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm transition">
                Editar
            </a>
            <a href="{{ route('medicamentos.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm transition">
                Voltar
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Princípio Ativo</p>
                <p class="font-medium text-gray-800">{{ $medicamento->principio_ativo }}</p>
            </div>
            <div>
                <p class="text-gray-500">Fabricante</p>
                <p class="font-medium text-gray-800">{{ $medicamento->fabricante }}</p>
            </div>
            <div>
                <p class="text-gray-500">Categoria</p>
                <p class="font-medium text-gray-800">{{ $medicamento->categoria }}</p>
            </div>
            <div>
                <p class="text-gray-500">Dosagem</p>
                <p class="font-medium text-gray-800">{{ $medicamento->dosagem ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Preço</p>
                <p class="font-medium text-gray-800">R$ {{ number_format($medicamento->preco, 2, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Estoque</p>
                <p class="font-medium">
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        {{ $medicamento->estoque > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $medicamento->estoque }} unidades
                    </span>
                </p>
            </div>
            <div>
                <p class="text-gray-500">Validade</p>
                <p class="font-medium text-gray-800">
                    {{ $medicamento->validade ? $medicamento->validade->format('d/m/Y') : '—' }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Requer Receita</p>
                <p class="font-medium">
                    @if($medicamento->requer_receita)
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">Sim</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-semibold">Não</span>
                    @endif
                </p>
            </div>
        </div>

        @if($medicamento->descricao)
        <div class="pt-2 border-t border-gray-100">
            <p class="text-gray-500 text-sm mb-1">Descrição</p>
            <p class="text-gray-800 text-sm">{{ $medicamento->descricao }}</p>
        </div>
        @endif

    </div>
</div>
@endsection