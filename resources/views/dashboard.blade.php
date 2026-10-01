<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Administración - ZendTicket</title>
    <!-- Fuentes de Google -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-gray-800 antialiased min-h-screen flex">

    <!-- 1. Barra Lateral de Navegación (Sidebar) -->
    <aside
        class="w-20 bg-white border-r border-gray-100 flex flex-col items-center py-6 justify-between shrink-0 md:flex">
        <div class="flex flex-col items-center gap-8 w-full">
            <!-- Isotipo ZendTicket -->
            <div
                class="w-10 h-10 bg-linear-to-tr from-[#10b981] to-[#34d399] rounded-xl flex items-center justify-center shadow-md shadow-emerald-100">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>

            <!-- Iconos de Navegación del Sistema -->
            <nav class="flex flex-col gap-5 w-full px-3">
                <a href="#"
                    class="p-3 bg-emerald-50 text-[#10b981] rounded-xl flex justify-center transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                    </svg>
                </a>
                <a href="#"
                    class="p-3 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-xl flex justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </a>
                <a href="#"
                    class="p-3 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-xl flex justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
                <a href="#"
                    class="p-3 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-xl flex justify-center transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
            </nav>
        </div>

        <!-- Sección de Usuario e Inicio/Cierre de Sesión -->
        <div class="flex flex-col items-center gap-4 w-full px-3">
            <!-- Avatar del Administrador -->
            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-inner cursor-pointer"
                title="Perfil de Administrador">
                AM
            </div>

            <!-- Botón de Logout -->
            <form method="POST" action="{{ route('logout') }}" class="w-full flex justify-center">
                @csrf
                <button type="submit"
                    class="p-3 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl flex justify-center transition-all w-full"
                    title="Cerrar Sesión">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenedor de Contenido Derecho -->
    <div class="grow flex flex-col min-w-0">

        <!-- 2. Barra Superior (Navbar del Panel) -->
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center gap-4 grow max-w-xl">
                <span class="text-lg font-bold text-gray-900 hidden lg:inline tracking-tight whitespace-nowrap">Mi
                    Trabajo</span>
                <!-- Buscador Central -->
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Buscar usuarios, tickets, solicitudes..."
                        class="w-full bg-slate-50 border border-gray-200 rounded-xl pl-9 pr-4 py-2 text-sm focus:outline-none 
                        focus:border-[#10b981] focus:bg-white transition-all">
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="flex items-center gap-4">
                <button
                    class="bg-[#22c55e] text-white px-4 py-2 rounded-xl text-xs font-bold shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    NUEVA SOLICITUD
                </button>
                <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 border border-gray-100 hidden sm:block">
                    <img src="https://rickandmortyapi.com/api/character/avatar/1.jpeg" alt="Admin Profile"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </header>

        <!-- 3. Grid Principal de Doble Columna (Workspace) -->
        <div class="grow grid grid-cols-12 gap-6 p-6 overflow-y-auto">

            <!-- COLUMNA IZQUIERDA (Métricas y Listado de Tickets) -->
            <div class="col-span-12 xl:col-span-9 flex flex-col gap-6">

                <!-- Fila de Contadores / Filtros Superiores -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div
                        class="bg-white border-b-4 border-rose-500 p-4 rounded-2xl shadow-xs text-center sm:text-left">
                        <span class="text-2xl font-black text-rose-500">3</span>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Esperando por mí
                        </p>
                    </div>
                    <div
                        class="bg-white border-b-4 border-amber-500 p-4 rounded-2xl shadow-xs text-center sm:text-left">
                        <span class="text-2xl font-black text-amber-500">6</span>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Asignados a mí</p>
                    </div>
                    <div
                        class="bg-white border-b-4 border-blue-500 p-4 rounded-2xl shadow-xs text-center sm:text-left">
                        <span class="text-2xl font-black text-blue-500">2</span>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Aprobaciones</p>
                    </div>
                    <div
                        class="bg-white border-b-4 border-emerald-500 p-4 rounded-2xl shadow-xs text-center sm:text-left">
                        <span class="text-2xl font-black text-emerald-500">2</span>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">Tareas pendientes
                        </p>
                    </div>
                </div>


            </div>
        </div>

</body>

</html>
