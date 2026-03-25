@extends('layouts.app')

@section('title', 'Esqueci minha senha')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md p-8">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" class="h-20 w-20 mb-3">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Recuperar senha</h1>
            <p class="text-sm text-gray-400 mt-1">Digite seu email para receber o link</p>
        </div>

        {{-- SUCESSO --}}
        @if(session('status'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERRO --}}
        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="seu@email.com"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                       focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <button type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 rounded-lg text-sm transition">
                Enviar link de recuperação
            </button>

            <p class="text-center text-sm text-gray-400 mt-4">
                Lembrou sua senha?
                <a href="{{ route('login') }}" class="text-teal-500 hover:underline font-medium">
                    Voltar para login
                </a>
            </p>
        </form>
    </div>
</div>
@endsection