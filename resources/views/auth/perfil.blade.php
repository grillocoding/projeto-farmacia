@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">

    <div class="flex items-center gap-4">
        <label for="foto-input" class="cursor-pointer relative group">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     alt="Foto de perfil"
                     class="w-16 h-16 rounded-full object-cover border-4 border-teal-400 shadow">
            @else
                <div class="w-16 h-16 rounded-full bg-teal-500 flex items-center justify-center text-white text-2xl font-bold shadow border-4 border-teal-300">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                <span class="text-white text-xs font-bold">📷</span>
            </div>
        </label>

        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</h1>
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                {{ Auth::user()->role === 'admin' ? 'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-700' : 'bg-teal-100 dark:bg-teal-900 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-700' }}">
                {{ Auth::user()->role === 'admin' ? '⭐ Admin' : '👤 Cliente' }}
            </span>
        </div>
    </div>

    {{-- FORM PRINCIPAL --}}
    <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <input type="file" id="foto-input" name="foto" accept="image/*"
               class="hidden" onchange="previewFoto(this)">

        {{-- Dados pessoais --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-4">Dados Pessoais</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400
                           @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400
                           @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CPF</label>
                    <input type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" placeholder="000.000.000-00"
                           maxlength="14" oninput="mascaraCpf(this)"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400
                           @error('cpf') border-red-400 @enderror">
                    @error('cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="(00) 00000-0000"
                           maxlength="15" oninput="mascaraTelefone(this)"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

            </div>
        </div>

        {{-- Endereço --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-4">Endereço</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                    <div class="relative">
                        <input type="text" id="cep" name="cep" value="{{ old('cep', $user->cep) }}"
                               placeholder="00000-000" maxlength="9" oninput="mascaraCep(this)"
                               class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                               focus:outline-none focus:ring-2 focus:ring-teal-400">
                        <span id="cep-loading" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 hidden">Buscando...</span>
                    </div>
                    <p id="cep-erro" class="text-red-500 text-xs mt-1 hidden">CEP não encontrado.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logradouro</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número</label>
                    <input type="text" name="numero" id="numero" value="{{ old('numero', $user->numero) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Complemento</label>
                    <input type="text" name="complemento" id="complemento" value="{{ old('complemento', $user->complemento) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bairro</label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $user->bairro) }}"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $user->cidade) }}"
                               class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                               focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                        <input type="text" name="estado" id="estado" maxlength="2" value="{{ old('estado', $user->estado) }}"
                               class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                               focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                </div>

            </div>
        </div>

        {{-- Alterar senha --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h2 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">Alterar Senha</h2>
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">Deixe em branco para manter a senha atual.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova Senha</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400
                           @error('password') border-red-400 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2 text-sm
                           bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100
                           focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

            </div>
        </div>

        {{-- Botões --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                Salvar Alterações
            </button>
            <a href="{{ Auth::user()->isAdmin() ? route('medicamentos.index') : route('perfil') }}"
            class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
    {{-- FIM FORM PRINCIPAL --}}

    {{-- 2FA FORA do form principal --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-gray-700 dark:text-gray-200">Autenticação em 2 Fatores</h2>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                {{ $user->two_factor_enabled ? '✅ O 2FA está ativado na sua conta.' : 'Adicione uma camada extra de segurança via WhatsApp.' }}
            </p>
        </div>
        <form action="{{ route('2fa.toggle') }}" method="POST">
            @csrf
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition
                    {{ $user->two_factor_enabled
                        ? 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 hover:bg-red-200'
                        : 'bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-300 hover:bg-teal-200' }}">
                {{ $user->two_factor_enabled ? '🔓 Desativar 2FA' : '🔒 Ativar 2FA' }}
            </button>
        </form>
    </div>

</div>

<script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const label = document.querySelector('label[for="foto-input"]');
                label.innerHTML = `
                    <img src="${e.target.result}" alt="Preview"
                         class="w-16 h-16 rounded-full object-cover border-4 border-teal-400 shadow">
                    <div class="absolute inset-0 rounded-full bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <span class="text-white text-xs font-bold">📷</span>
                    </div>
                `;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

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

    function mascaraCep(input) {
        let v = input.value.replace(/\D/g, '');
        if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5, 8);
        input.value = v;
        if (v.length === 9) buscarCep(v);
    }

    async function buscarCep(cep) {
        const loading = document.getElementById('cep-loading');
        const erro    = document.getElementById('cep-erro');
        erro.classList.add('hidden');
        loading.classList.remove('hidden');
        try {
            const res  = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await res.json();
            if (data.erro) { erro.classList.remove('hidden'); return; }
            document.getElementById('address').value = data.logradouro;
            document.getElementById('bairro').value  = data.bairro;
            document.getElementById('cidade').value  = data.localidade;
            document.getElementById('estado').value  = data.uf;
            document.getElementById('numero').focus();
        } catch (e) {
            erro.classList.remove('hidden');
        } finally {
            loading.classList.add('hidden');
        }
    }
</script>

@endsection