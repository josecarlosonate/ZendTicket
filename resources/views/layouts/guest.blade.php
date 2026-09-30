<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ZendTicket')</title>
    <!-- Fuentes de Google -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com" rel="stylesheet">

    <!-- Tailwind CSS (Vía Vite o CDN para asegurar visualización) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Navbar -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo principal -->
            <a href={{ route('home') }}>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-linear-to-tr from-[#10b981] to-[#34d399] rounded-xl flex items-center justify-center shadow-md shadow-emerald-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-gray-900">Zend<span
                                class="text-[#10b981]">Ticket</span></span>
                        <p class="text-[10px] text-gray-400 font-medium tracking-wider uppercase -mt-1">Support System
                        </p>
                    </div>
                </div>
            </a>

            <!-- Botón Volver al Inicio -->
            <div>
                <a href={{ route('home') }}
                    class="px-5 py-2.5 rounded-xl bg-emerald-50 text-[#10b981] font-semibold text-sm hover:bg-emerald-100 transition-all">
                    Volver al inicio
                </a>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Marca -->
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 bg-linear-to-tr from-[#10b981] to-[#34d399] rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-white">Zend<span class="text-[#10b981]">Ticket</span></p>
                    <p class="text-xs text-gray-500">Gestión de soporte organizada</p>
                </div>
            </div>

            <!-- Copyright -->
            <p class="text-sm text-center">&copy; {{ date('Y') }} ZendTicket. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>
