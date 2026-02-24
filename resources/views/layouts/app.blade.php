<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Farmácia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-blue-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="text-xl font-bold tracking-wide">💊 Farmácia</a>
            <div class="flex gap-6 text-sm font-medium">
                <a href="{{ route('medicamentos.index') }}" class="hover:text-blue-200 transition">Medicamentos</a>
                <a href="{{ route('pedidos.index') }}" class="hover:text-blue-200 transition">Pedidos</a>
                <a href="{{ route('users.index') }}" class="hover:text-blue-200 transition">Usuários</a>
            </div>
        </div>
    </nav>

    {{-- Conteúdo --}}
    <main class="max-w-7xl mx-auto px-4 py-8">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>