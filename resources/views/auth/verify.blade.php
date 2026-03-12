@extends('layouts.app')

@section('title', 'Verificação em 2 Fatores')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8">

        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-20 object-contain mb-3">
            <h1 class="text-2xl font-bold text-gray-800">Verificação SMS</h1>
            <p class="text-sm text-gray-400 mt-1 text-center">
                Enviamos um código de 6 dígitos para o seu celular. <br>
                O código expira em 10 minutos.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('2fa.verify.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código de verificação</label>
                <input type="text" name="code" maxlength="6" placeholder="000000" autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-center tracking-widest text-xl
                       focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('code') border-red-400 @enderror">
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 rounded-lg text-sm transition">
                Verificar
            </button>

            <p class="text-center text-sm text-gray-400">
                Não recebeu o código?
                <a href="{{ route('login') }}" class="text-teal-500 hover:underline font-medium">
                    Tentar novamente
                </a>
            </p>

        </form>
    </div>
</div>
@endsection
