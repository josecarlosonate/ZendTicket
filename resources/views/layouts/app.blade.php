<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- El título se volverá dinámico gracias a las vistas hijas -->
    <title>@yield('title', 'ZendTicket')</title>

    <!-- Fuentes de Google -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>


    <!-- Tailwind CSS (Vía Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800 antialiased min-h-screen flex">

    <!-- 1. Barra Lateral de Navegación (Sidebar Sticky) -->
    <aside
        class="w-20 bg-emerald-700 border-r border-emerald-800/30 flex flex-col items-center py-6 justify-between shrink-0 md:flex h-screen sticky top-0 z-40">
        <div class="flex flex-col items-center gap-8 w-full">
            <!-- Isotipo ZendTicket -->
            <a href="/">
                <div
                    class="w-10 h-10 bg-linear-to-tr from-[#10b981] to-[#34d399] rounded-xl flex items-center justify-center 
                    shadow-md shadow-emerald-100 hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </a>

            <!-- Iconos de Navegación del Sistema -->
            <nav class="flex flex-col gap-5 w-full px-3">
                <a href="{{ route('dashboard') }}"
                    class="p-3 rounded-xl flex justify-center transition-all 
                    {{ request()->routeIs('dashboard')
                        ? 'bg-white text-emerald-800 shadow-md shadow-emerald-950/10'
                        : 'text-emerald-100/75 hover:text-white hover:bg-white/10' }}"
                    title="Panel Principal">
                    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                </a>
                <a href="{{ route('tickets.index') }}"
                    class="p-3 rounded-xl flex justify-center transition-all 
                    {{ request()->routeIs('tickets.*')
                        ? 'bg-white text-emerald-800 shadow-md shadow-emerald-950/10'
                        : 'text-emerald-100/75 hover:text-white hover:bg-white/10' }}"
                    title="Modulo Tickets">
                    <x-heroicon-o-ticket class="w-5 h-5" />
                </a>
            </nav>

        </div>
    </aside>

    <!-- Contenedor Derecho Completo -->
    <div class="grow flex flex-col min-w-0 min-h-screen">

        <!-- 2. Barra Superior (Navbar Global) -->
        <header class="h-20 bg-white/90 backdrop-blur border-b border-emerald-100/80 flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center gap-4 grow max-w-xl">
                @unless (Auth::user()->hasRole('customer'))
                    <!-- La búsqueda global se habilitará cuando exista funcionalidad real para los perfiles internos. -->
                @endunless
            </div>

            <!-- Información y Nombre del Usuario -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900 tracking-tight leading-tight">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">
                        {{ Auth::user()->roles->first()->name }}
                    </p>
                </div>

                <div class="relative">
                    <button id="layoutUserMenuBtn"
                        class="w-9 h-9 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-xs font-bold text-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#10b981] transition-all cursor-pointer"
                        aria-label="Abrir menú de usuario">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                    </button>

                    <!-- Tarjeta Desplegable Flotante (Alineada a la derecha de la foto) -->
                    <div id="layoutUserDropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50 animate-fade-in">
                        <div class="px-4 py-2 border-b border-gray-50">
                            <p class="text-xs font-bold text-gray-900 truncate">
                                {{ Auth::user()->name }} </p>
                            <p class="text-[10px] text-gray-400 truncate">
                                {{ Auth::user()->email }}</p>
                        </div>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-gray-600 hover:bg-slate-50 
                            hover:text-gray-900 transition-colors">
                            <x-heroicon-o-user class="w-4 h-4" />
                            Mi Perfil
                        </a>
                        <div class="border-t border-gray-50 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 
                                transition-colors text-left">
                                <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4" />
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </header>

        <!-- 3. Contenedor de Inyección Dinámica de Contenido -->
        <div class="grow overflow-y-auto bg-[#f3f8f5]">
            @yield('content')
        </div>

    </div>

    @stack('scripts')
</body>

</html>
