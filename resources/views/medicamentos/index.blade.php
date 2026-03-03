@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Medicamentos</h1>
    <a href="{{ route('medicamentos.create') }}"
       class="bg-teal-500 hover:bg-teal-500 text-white px-4 py-2 rounded shadow text-sm transition">
        + Novo Medicamento
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-teal-500 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Imagem</th>
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
                <td class="px-4 py-3">
                    @if($medicamento->imagem)
                        <img src="{{ Storage::url($medicamento->imagem) }}" alt="{{ $medicamento->nome }}"
                             class="w-10 h-10 object-cover rounded border border-gray-200">
                    @else
                        <div class="w-10 h-10 bg-gray-100 rounded border border-gray-200 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </td>
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