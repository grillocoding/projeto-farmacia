@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md p-8">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20 object-contain mb-3">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Criar Conta</h1>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Preencha os dados para se cadastrar</p>
        </div>

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name') }}" autofocus
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00"
                       maxlength="14" oninput="mascaraCpf(this)"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('cpf') border-red-400 @enderror">
                @error('cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="(00) 00000-0000"
                       maxlength="15" oninput="mascaraTelefone(this)"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha *</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Senha *</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <button type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 rounded-lg text-sm transition">
                Cadastrar
            </button>

            <p class="text-center text-sm text-gray-400 dark:text-gray-500 mt-4">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="text-teal-500 hover:underline font-medium">
                    Faça login
                </a>
            </p>

        </form>
    </div>
</div>

<script>
    function mascaraCpf(input) {
        let v = input.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);
        if (v.length > 9)      v = v.slice(0,3) + '.' + v.slice(3,6) + '.' + v.slice(6,9) + '-' + v.slice(9);
        else if (v.length > 6) v = v.slice(0,3) + '.' + v.slice(3,6) + '.' + v.slice(6);
        else if (v.length > 3) v = v.slice(0,3) + '.' + v.slice(3);
        input.value = v;
    }

    function mascaraTelefone(input) {
        let v = input.value.replace(/\D/g, '');
        if (v.length > 11) v = v.slice(0, 11);
        if (v.length > 10)      v = '(' + v.slice(0,2) + ') ' + v.slice(2,7) + '-' + v.slice(7);
        else if (v.length > 6)  v = '(' + v.slice(0,2) + ') ' + v.slice(2,6) + '-' + v.slice(6);
        else if (v.length > 2)  v = '(' + v.slice(0,2) + ') ' + v.slice(2);
        else if (v.length > 0)  v = '(' + v;
        input.value = v;
    }
</script>
@endsection