@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-xl font-bold text-gray-800 mb-6">Editar Usuário</h1>

    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nova Senha
                    <span class="text-gray-400 font-normal">(deixe em branco para manter)</span>
                </label>
                <input type="password" name="password"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('password') border-red-400 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Perfil *</label>
                <select name="role"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <option value="cliente" {{ old('role', $user->role) === 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" placeholder="000.000.000-00"
                       maxlength="14" oninput="mascaraCpf(this)"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400
                       @error('cpf') border-red-400 @enderror">
                @error('cpf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="(00) 00000-0000"
                       maxlength="15" oninput="mascaraTelefone(this)"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}"
                         alt="Foto atual"
                         class="w-16 h-16 rounded-full object-cover mb-2 border-2 border-teal-400">
                @endif
                <input type="file" name="foto" accept="image/*" onchange="previewFoto(this)"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 bg-white">
                <img id="foto-preview" src="#" alt="Preview"
                     class="w-16 h-16 rounded-full object-cover mt-2 border-2 border-teal-400 hidden">
            </div>

        </div>

        {{-- Endereço --}}
        <div class="border-t border-gray-100 pt-4">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Endereço</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CEP</label>
                    <div class="relative">
                        <input type="text" id="cep" name="cep" value="{{ old('cep', $user->cep) }}"
                               placeholder="00000-000" maxlength="9" oninput="mascaraCep(this)"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                        <span id="cep-loading" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 hidden">Buscando...</span>
                    </div>
                    <p id="cep-erro" class="text-red-500 text-xs mt-1 hidden">CEP não encontrado.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logradouro</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                    <input type="text" name="numero" id="numero" value="{{ old('numero', $user->numero) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
                    <input type="text" name="complemento" id="complemento" value="{{ old('complemento', $user->complemento) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
                    <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $user->bairro) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $user->cidade) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <input type="text" name="estado" id="estado" maxlength="2" value="{{ old('estado', $user->estado) }}"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                    </div>
                </div>

            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition shadow-sm">
                Atualizar
            </button>
            <a href="{{ route('users.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm transition">
                Cancelar
            </a>
        </div>

    </form>
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

    function mascaraCep(input) {
        let v = input.value.replace(/\D/g, '');
        if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5, 8);
        input.value = v;
        if (v.length === 9) buscarCep(v);
    }

    function previewFoto(input) {
        const preview = document.getElementById('foto-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
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