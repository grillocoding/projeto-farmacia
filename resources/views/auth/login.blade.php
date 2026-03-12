@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md p-8">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20 object-contain mb-3">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Farmácia</h1>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Faça login para continuar</p>
        </div>

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" autofocus
                       placeholder="seu@email.com"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           placeholder="••••••••"
                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400
                           @error('password') border-red-400 @enderror">
                    <button type="button" onclick="toggleSenha()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                        👁
                    </button>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-teal-500">
                    Lembrar-me
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 rounded-lg text-sm transition">
                Entrar
            </button>

            <p class="text-center text-sm text-gray-400 dark:text-gray-500 mt-4">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="text-teal-500 hover:underline font-medium">
                    Cadastre-se
                </a>
            </p>

        </form>
    </div>
</div>

<script>
    function toggleSenha() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection