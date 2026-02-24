@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Medicamentos</h1>
    <a href="{{ route('medicamentos.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm transition">
        + Novo Medicamento
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-green-600 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nome</th>
                <th class="px-4 py-3">Categoria</th>
                <th class="px-4 py-3">Preço</th>
                <th class="px-4 py-3">Estoque</th>
                <th class="px-4 py-3">Receita</th>
                <th class="px-4 py-3">Validade</th>
                <th class="px-4 py-3">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($medicamentos as $medicamento)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-500">{{ $medicamento->id }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $medicamento->nome }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $medicamento->categoria }}</td>
                <td class="px-4 py-3 text-gray-600">R$ {{ number_format($medicamento->preco, 2, ',', '.') }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        {{ $medicamento->estoque > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $medicamento->estoque }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($medicamento->requer_receita)
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">Sim</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-semibold">Não</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-600">
                    {{ $medicamento->validade ? $medicamento->validade->format('d/m/Y') : '—' }}
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('medicamentos.show', $medicamento) }}"
                       class="text-blue-600 hover:underline text-xs">Ver</a>
                    <a href="{{ route('medicamentos.edit', $medicamento) }}"
                       class="text-yellow-600 hover:underline text-xs">Editar</a>
                    <form action="{{ route('medicamentos.destroy', $medicamento) }}" method="POST"
                          onsubmit="return confirm('Tem certeza?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-xs">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-6 text-center text-gray-400">Nenhum medicamento cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginação --}}
<div class="mt-4">
    {{ $medicamentos->links() }}
</div>
@endsection