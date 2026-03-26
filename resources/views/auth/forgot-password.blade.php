@extends('layouts.app')

@section('title', 'Recuperar Senha')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md p-8">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20 object-contain mb-3">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Farmácia</h1>
            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Informe seu email para recuperar a senha</p>
        </div>

        @if(session('status'))
            <div class="mb-4 px-4 py-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
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

            <button type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 rounded-lg text-sm transition">
                Enviar link de recuperação
            </button>

            <p class="text-center text-sm text-gray-400 dark:text-gray-500 mt-4">
                Lembrou a senha?
                <a href="{{ route('login') }}" class="text-teal-500 hover:underline font-medium">
                    Voltar ao login
                </a>
            </p>

        </form>
    </div>
</div>
@endsection