@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nova Senha
                    <span class="text-gray-400 font-normal">(deixe em branco para manter)</span>
                </label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perfil *</label>
                <select name="role"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="cliente" {{ old('role', $user->role) === 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('cpf') border-red-400 @enderror">
                @error('cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded text-sm transition">
                Atualizar
            </button>
            <a href="{{ route('users.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection