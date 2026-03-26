<!DOCTYPE html>
<html lang="pt-BR" x-data="{ dark: localStorage.getItem('dark') === 'true' }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Farmácia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen transition-colors duration-300">

    <nav class="bg-teal-500 dark:bg-gray-800 text-white shadow-md transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 object-contain drop-shadow-md">
                <span class="text-xl font-bold tracking-wide">Farmácia</span>
            </a>

            @auth   
            <div class="flex items-center gap-2">
                
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('medicamentos.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-teal-400 dark:hover:bg-gray-700">
                        Medicamentos
                    </a>
                    <a href="{{ route('pedidos.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-teal-400 dark:hover:bg-gray-700">
                        Pedidos
                    </a>
                    <a href="{{ route('users.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-teal-400 dark:hover:bg-gray-700">
                        Usuários
                    </a>
                @else
                    <a href="{{ route('medicamentos.index') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition hover:bg-teal-400 dark:hover:bg-gray-700">
                        Medicamentos
                    </a>
                @endif

                <div class="w-px h-6 bg-teal-400 dark:bg-gray-600 mx-2"></div>

                {{-- Carrinho --}}
                @if(!Auth::user()->isAdmin())
                    @php
                        $carrinho = (Auth::check() && !Auth::user()->isAdmin())
                            ? \App\Models\Pedido::where('user_id', Auth::id())
                                ->where('status', 'carrinho')
                                ->with('items.medicamento')
                                ->first()
                            : null;
                        $totalItens = $carrinho ? $carrinho->items()->sum('quantidade') : 0;
                    @endphp
                    <div x-data="{ aberto: false }" class="relative">
                        <button @click="aberto = !aberto"
                                class="relative px-3 py-2 rounded-lg hover:bg-teal-400 dark:hover:bg-gray-700 transition">
                                🛒
                            @if($totalItens > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $totalItens }}
                                </span>
                            @endif
                        </button>

                        {{-- Aba lateral do carrinho --}}
                        <div x-show="aberto" @click.outside="aberto = false"
                            class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 p-4">
                            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">🛒 Meu Carrinho</h3>
                            @if($totalItens > 0)
                                @foreach($carrinho->items as $item)
                                    <div class="flex items-center justify-between mb-2 text-sm">
                                        <span class="text-gray-700 dark:text-gray-300">{{ $item->medicamento->nome }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-500">x{{ $item->quantidade }}</span>
                                            <span class="font-bold text-gray-800 dark:text-gray-100">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</span>
                                            <form action="{{ route('carrinho.remover', $item) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="text-red-400 hover:text-red-600 text-xs">✕</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="border-t border-gray-100 dark:border-gray-700 pt-2 mt-2">
                                    <div class="flex justify-between text-sm font-bold mb-3">
                                        <span>Total</span>
                                        <span>R$ {{ number_format($carrinho->total, 2, ',', '.') }}</span>
                                    </div>
                                    <a href="{{ route('carrinho.pagamento') }}"
                                       class="block w-full bg-teal-500 hover:bg-teal-600 text-white py-2 rounded-lg text-sm font-semibold transition text-center">
                                        Finalizar Compra
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 text-center py-4">Carrinho vazio</p>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Botão dark mode --}}
                <button @click="dark = !dark; localStorage.setItem('dark', dark)"
                        class="px-3 py-2 rounded-lg hover:bg-teal-400 dark:hover:bg-gray-700 transition text-sm"
                        :title="dark ? 'Modo claro' : 'Modo escuro'">
                    <span x-show="!dark">🌙</span>
                    <span x-show="dark">☀️</span>
                </button>

                <div class="w-px h-6 bg-teal-400 dark:bg-gray-600 mx-1"></div>

                {{-- Avatar + Nome --}}
                <a href="{{ route('perfil') }}"
                   class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-teal-400 dark:hover:bg-gray-700 transition">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                             alt="Foto"
                             class="w-8 h-8 rounded-full object-cover border-2 border-white shadow">
                    @else
                        <div class="w-8 h-8 rounded-full bg-white text-teal-600 flex items-center justify-center text-sm font-bold shadow">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                </a>

                {{-- Botão Sair --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-1 px-4 py-2 bg-white text-teal-600 hover:bg-red-500 hover:text-white dark:bg-gray-700 dark:text-white dark:hover:bg-red-600 font-semibold rounded-lg text-sm shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                        </svg>
                        Sair
                    </button>
                </form>

            </div>
            @endauth

            @guest
                <div class="flex items-center gap-2">
                    <button @click="dark = !dark; localStorage.setItem('dark', dark)"
                            class="px-3 py-2 rounded-lg hover:bg-teal-400 dark:hover:bg-gray-700 transition text-sm">
                        <span x-show="!dark">🌙</span>
                        <span x-show="dark">☀️</span>
                    </button>
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-white text-teal-600 rounded-lg text-sm font-semibold hover:bg-teal-50 transition">
                        Login
                    </a>
                </div>
            @endguest

        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-teal-100 dark:bg-teal-900 border border-teal-400 dark:border-teal-700 text-teal-800 dark:text-teal-200 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>