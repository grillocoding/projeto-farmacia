@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">Usuários</h1>
    <a href="{{ route('users.create') }}"
       class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        + Novo Usuário
    </a>
</div>

<form method="GET" action="{{ route('users.index') }}" class="mb-4 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Buscar por nome ou ID..."
           class="flex-1 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
           focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-sm">
    <button type="submit"
            class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        🔍 Buscar
    </button>
    @if(request('search'))
        <a href="{{ route('users.index') }}"
           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-lg text-sm transition">
            ✕
        </a>
    @endif
</form>

@if($users->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 py-12 text-center">
        <p class="text-4xl mb-3">👤</p>
        <p class="text-gray-400 dark:text-gray-500 text-sm">Nenhum usuário cadastrado.</p>
        <a href="{{ route('users.create') }}" class="mt-3 inline-block text-teal-500 hover:underline text-sm">
            Cadastrar primeiro usuário
        </a>
    </div>
@else
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-teal-500 dark:bg-teal-700 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Foto</th>
                <th class="px-4 py-3">Nome</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">CPF</th>
                <th class="px-4 py-3">Telefone</th>
                <th class="px-4 py-3">Perfil</th>
                <th class="px-4 py-3">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
            @foreach($users as $user)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                <td class="px-4 py-3">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}"
                             alt="{{ $user->name }}"
                             class="w-9 h-9 rounded-full object-cover border-2 border-teal-300">
                    @else
                        <div class="w-9 h-9 rounded-full bg-teal-500 flex items-center justify-center text-white text-sm font-bold border-2 border-teal-300">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </td>

                <td class="px-4 py-3">
                    <span class="font-semibold text-gray-800 dark:text-gray-100 text-xs">{{ $user->name }}</span>
                </td>

                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</td>
                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $user->cpf ?? '—' }}</td>
                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">{{ $user->phone ?? '—' }}</td>

                <td class="px-4 py-3">
                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-bold bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-700">
                            ⭐ Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-bold bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-700">
                            👤 Cliente
                        </span>
                    @endif
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center gap-1">
                        <a href="{{ route('users.show', $user) }}"
                           class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900 hover:bg-blue-100 text-blue-600 dark:text-blue-300 rounded-lg text-xs font-medium transition">
                            👁 Ver
                        </a>
                        <a href="{{ route('users.edit', $user) }}"
                           class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-50 dark:bg-yellow-900 hover:bg-yellow-100 text-yellow-600 dark:text-yellow-300 rounded-lg text-xs font-medium transition">
                            ✏️ Editar
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Excluir {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 dark:bg-red-900 hover:bg-red-100 text-red-600 dark:text-red-300 rounded-lg text-xs font-medium transition">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endif

@endsection