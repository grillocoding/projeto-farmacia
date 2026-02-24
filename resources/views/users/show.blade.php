@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('users.edit', $user) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm transition">
                Editar
            </a>
            <a href="{{ route('users.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded text-sm transition">
                Voltar
            </a>
        </div>
    </div>

    {{-- Dados do usuário --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-sm font-semibold text-gray-500 uppercase mb-4">Dados Pessoais</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Email</p>
                <p class="font-medium text-gray-800">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-gray-500">Perfil</p>
                <span class="px-2 py-1 rounded text-xs font-semibold
                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            <div>
                <p class="text-gray-500">CPF</p>
                <p class="font-medium text-gray-800">{{ $user->cpf ?? '—' }}</p>
            </div>
            <div>
                <p class="text-gray-500">Telefone</p>
                <p class="font-medium text-gray-800">{{ $user->phone ?? '—' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500">Endereço</p>
                <p class="font-medium text-gray-800">{{ $user->address ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Pedidos do usuário --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-500 uppercase">Pedidos</h2>
            <span class="text-xs text-gray-400">{{ $user->pedidos->count() }} pedido(s)</span>
        </div>

        @if($user->pedidos->isEmpty())
            <p class="px-6 py-4 text-sm text-gray-400">Nenhum pedido encontrado.</p>
        @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Data</th>
                    <th class="px-6 py-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($user->pedidos as $pedido)
                @php
                    $cores = [
                        'pendente'  => 'bg-yellow-100 text-yellow-700',
                        'aprovado'  => 'bg-blue-100 text-blue-700',
                        'enviado'   => 'bg-purple-100 text-purple-700',
                        'entregue'  => 'bg-green-100 text-green-700',
                        'cancelado' => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-gray-500">{{ $pedido->id }}</td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $cores[$pedido->status] }}">
                            {{ ucfirst($pedido->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-600">R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('pedidos.show', $pedido) }}"
                           class="text-blue-600 hover:underline text-xs">Ver pedido</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection