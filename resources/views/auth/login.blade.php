@extends('layouts.guest')

@section('title', 'Iniciar Sesión - ZendTicket')

@section('content')
    <!-- Contenido Principal: Formulario de Login -->
    <main class="grow flex items-center justify-center px-6 py-12 relative overflow-hidden">
        <!-- Fondo Decorativo Sutil Detrás de la Tarjeta -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-100/50 rounded-full blur-3xl -z-10">
        </div>

        <div
            class="w-full max-w-md bg-white border border-gray-100 p-8 md:p-10 rounded-3xl shadow-xl shadow-gray-200/50 space-y-6">
            <!-- Encabezado de la Tarjeta -->
            <div class="text-center space-y-2">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">¡Bienvenido de nuevo!</h1>
                <p class="text-sm text-gray-500">Ingresa tus credenciales para acceder a tu panel de soporte.</p>
            </div>

            <!-- Formulario -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Campo de Email -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500">Correo
                        Electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required autocomplete="email"
                            placeholder="nombre@empresa.com"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] focus:bg-white transition-all placeholder:text-gray-400" />
                    </div>
                </div>

                <!-- Campo de Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password"
                            class="text-xs font-bold uppercase tracking-wider text-gray-500">Contraseña</label>
                        <a href="#" class="text-xs font-semibold text-[#10b981] hover:underline">¿La
                            olvidaste?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] focus:bg-white transition-all placeholder:text-gray-400" />
                    </div>
                </div>

                <!-- Recordarme (Opcional, muy útil en logins) -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember_me" name="remember"
                        class="w-4 h-4 text-[#10b981] border-gray-300 rounded focus:ring-[#10b981]">
                    <label for="remember_me" class="ml-2 text-sm text-gray-500 select-none">Recordar mi sesión</label>
                </div>

                <!-- Botón de Envío -->
                <button type="submit"
                    class="w-full px-5 py-3.5 rounded-xl bg-[#22c55e] text-white font-bold text-sm shadow-lg shadow-emerald-100 hover:bg-[#16a34a] hover:shadow-none transition-all uppercase tracking-wider">
                    Ingresar al Sistema
                </button>
            </form>
        </div>
    </main>
@endsection
