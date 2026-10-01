<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZendTicket - Gestión de Soporte Organizada</title>
    <!-- Fuentes de Google -->
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            <!-- Logo inspirado en la estructura del menú digital -->
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

            <!-- Navegación -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#inicio" class="hover:text-[#10b981] transition-colors">Inicio</a>
                <a href="#problema" class="hover:text-[#10b981] transition-colors">¿Qué resuelve?</a>
                <a href="#sectores" class="hover:text-[#10b981] transition-colors">Sectores</a>
            </nav>

            <!-- Acceso (Estilo botón 'Iniciar Sesión' de la imagen) -->
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2.5 rounded-xl bg-emerald-50 text-[#10b981] font-semibold text-sm hover:bg-emerald-100 transition-all">Panel
                            de Control</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 rounded-xl bg-[#22c55e] text-white font-semibold text-sm shadow-lg shadow-emerald-200 hover:bg-[#16a34a] hover:shadow-none transition-all">INICIAR
                            SESIÓN</a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section (Usa el degradado curvo y envolvente de la imagen de referencia) -->
    <main class="grow">
        <section id="inicio"
            class="relative overflow-hidden bg-linear-to-b from-emerald-500 via-emerald-600 to-green-700 text-white pt-20 pb-32 rounded-b-[40px] md:rounded-b-[80px] shadow-2xl">
            <!-- Capa decorativa orgánica de fondo -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,var(--tw-gradient-stops))] from-white via-transparent to-transparent">
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 grid md:grid-cols-12 gap-12 items-center">
                <div class="md:col-span-7 space-y-6 text-center md:text-left">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-xs font-semibold tracking-wide uppercase">
                        🚀 Optimiza tu negocio
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
                        Transforma solicitudes desorganizadas en un <span class="text-emerald-200">proceso claro</span>
                    </h1>
                    <p class="text-lg md:text-xl text-emerald-50/90 font-medium max-w-2xl leading-relaxed">
                        ZendTicket centraliza cada caso en un ticket inteligente. Deja atrás el caos de WhatsApp,
                        correos perdidos o llamadas telefónicas.
                    </p>
                    <div class="pt-3 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="#problema"
                            class="px-8 py-4 rounded-xl bg-white text-emerald-700 font-bold shadow-xl hover:bg-emerald-50 transition-all text-center">
                            Saber más
                        </a>
                        <a href="#"
                            class="px-8 py-4 rounded-xl bg-emerald-700/50 border border-emerald-400/30 text-white font-bold backdrop-blur-sm hover:bg-emerald-700/80 transition-all text-center">
                            Ver demostración
                        </a>
                    </div>
                </div>

                <!-- Elemento visual interactivo que simula los paneles dinámicos de la imagen -->
                <div class="md:col-span-5 relative flex justify-center">
                    <div
                        class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl shadow-2xl space-y-6">
                        <div class="flex justify-between items-center border-b border-white/10 pb-4">
                            <span class="font-bold text-lg">Estado del Servicio</span>
                            <div class="flex gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-400 animate-pulse"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400"></span>
                            </div>
                        </div>
                        <!-- Contadores estilo display numérico de la imagen -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 border border-white/10 p-4 rounded-2xl text-center">
                                <p class="text-xs text-emerald-200 uppercase font-bold tracking-wider">Nuevos</p>
                                <p class="text-3xl font-black mt-1 text-white">04</p>
                            </div>
                            <div class="bg-white/5 border border-white/10 p-4 rounded-2xl text-center">
                                <p class="text-xs text-emerald-200 uppercase font-bold tracking-wider">Pendientes</p>
                                <p class="text-3xl font-black mt-1 text-white">12</p>
                            </div>
                        </div>
                        <div
                            class="bg-white text-gray-800 p-4 rounded-2xl shadow-lg flex items-center gap-4 text-sm font-medium">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Última solicitud atendida</p>
                                <p class="text-gray-700 font-semibold truncate">Soporte técnico - Ticket #402</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: Problema y Respuestas -->
        <section id="problema" class="max-w-7xl mx-auto px-6 py-24">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    ¿Qué problema resuelve ZendTicket?
                </h2>
                <p class="text-gray-500 text-base md:text-lg">
                    Evita que las solicitudes importantes terminen perdidas en bandejas de entrada infinitas o
                    conversaciones personales. Te da el control absoluto para responder con certeza:
                </p>
            </div>

            <!-- Grid de preguntas resueltas -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        👤</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Quién atiende el problema?</h4>
                        <p class="text-sm text-gray-500">Asigna responsables automáticos o manuales a cada área o
                            categoría.</p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        🚨</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Qué tan urgente es?</h4>
                        <p class="text-sm text-gray-500">Clasifica las incidencias por prioridades para resolver primero
                            lo crítico.</p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        ⏳</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Cuánto lleva esperando?</h4>
                        <p class="text-sm text-gray-500">Mide los tiempos desde la apertura del ticket hasta su solución
                            definitiva.</p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        🛠️</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Qué se ha hecho?</h4>
                        <p class="text-sm text-gray-500">Accede al historial completo de acciones, cambios de estado y
                            notas internas.</p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        📋</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Qué sigue pendiente?</h4>
                        <p class="text-sm text-gray-500">Visualiza rápidamente mediante un panel central los casos sin
                            resolver</p>
                    </div>
                </div>
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-50 text-[#10b981] flex items-center justify-center font-bold text-lg shrink-0">
                        📈</div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">¿Cómo rinde el equipo?</h4>
                        <p class="text-sm text-gray-500">Analiza métricas de rendimiento y eficiencia de tus agentes de
                            soporte.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: sectores -->
        <section id="sectores" class="max-w-7xl mx-auto px-6 py-24">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Adaptable a cualquier infraestructura
                </h2>
                <p class="text-gray-500 text-base md:text-lg">
                    Cualquier organización que necesite recibir, asignar y hacer un seguimiento riguroso de solicitudes
                    encuentra en ZendTicket su mejor aliado.
                </p>
            </div>

            <!-- lista de sectores -->
            <!-- Sectores -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm
               hover:shadow-md transition-shadow">

                    <div
                        class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 text-[#10b981]
                   flex items-center justify-center text-xl">
                        💻
                    </div>

                    <h3 class="font-bold text-gray-900 mb-2">
                        Soporte Técnico
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Gestiona incidencias de software, hardware, accesos y servicios tecnológicos.
                    </p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm
               hover:shadow-md transition-shadow">

                    <div
                        class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 text-[#10b981]
                   flex items-center justify-center text-xl">
                        🏫
                    </div>

                    <h3 class="font-bold text-gray-900 mb-2">
                        Instituciones Educativas
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Centraliza solicitudes de estudiantes, docentes y personal administrativo.
                    </p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm
               hover:shadow-md transition-shadow">

                    <div
                        class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 text-[#10b981]
                   flex items-center justify-center text-xl">
                        🏢
                    </div>

                    <h3 class="font-bold text-gray-900 mb-2">
                        Áreas Administrativas
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Organiza solicitudes internas entre departamentos y equipos de trabajo.
                    </p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm
               hover:shadow-md transition-shadow">

                    <div
                        class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 text-[#10b981]
                   flex items-center justify-center text-xl">
                        🛠️
                    </div>

                    <h3 class="font-bold text-gray-900 mb-2">
                        Mantenimiento
                    </h3>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Registra, asigna y realiza seguimiento a solicitudes de mantenimiento.
                    </p>
                </div>

            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-gray-400">
        <div
            class="max-w-7xl mx-auto px-6 py-8
               flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Marca -->
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 bg-linear-to-tr from-[#10b981] to-[#34d399]
                       rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0
                           002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2
                           2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6
                           9l2 2 4-4" />
                    </svg>
                </div>

                <div>
                    <p class="font-bold text-white">
                        Zend<span class="text-[#10b981]">Ticket</span>
                    </p>

                    <p class="text-xs text-gray-500">
                        Gestión de soporte organizada
                    </p>
                </div>
            </div>

            <!-- Copyright -->
            <p class="text-sm text-center">
                &copy; {{ date('Y') }} ZendTicket. Todos los derechos reservados.
            </p>
        </div>
    </footer>

</body>

</html>
