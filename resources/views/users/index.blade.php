@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Usuários</h1>
    <a href="{{ route('users.create') }}"
       class="bg-teal-500 hover:bg-teal-500 text-white px-4 py-2 rounded shadow text-sm transition">
        + Novo Usuário
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-teal-500 text-white uppercase text-xs">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nome</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">CPF</th>
                <th class="px-4 py-3">Telefone</th>
                <th class="px-4 py-3">Perfil</th>
                <th class="px-4 py-3">Ações</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-gray-500">{{ $user->id }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $user->cpf ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $user->phone ?? '—' }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-xs font-semibold
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('users.show', $user) }}"
                       class="text-blue-600 hover:underline text-xs">Ver</a>
                    <a href="{{ route('users.edit', $user) }}"
                       class="text-yellow-600 hover:underline text-xs">Editar</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Tem certeza?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-xs">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400">Nenhum usuário cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection