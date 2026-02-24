@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Novo Usuário</h1>

    <form action="{{ route('users.store') }}" method="POST"
          class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Senha *</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Senha *</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perfil *</label>
                <select name="role"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                        @error('role') border-red-400 @enderror">
                    <option value="cliente" {{ old('role') === 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400
                       @error('cpf') border-red-400 @enderror">
                @error('cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="(00) 00000-0000"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded text-sm transition">
                Salvar
            </button>
            <a href="{{ route('users.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
</div>
@endsection