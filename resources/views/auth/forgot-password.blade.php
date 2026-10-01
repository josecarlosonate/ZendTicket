@extends('layouts.guest')

@section('title', 'Recuperar contraseña - ZendTicket')

@section('content')

    <div class="grow flex items-center justify-center px-6 py-12 relative overflow-hidden">
        <!-- Fondo Decorativo Sutil Detrás de la Tarjeta -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-125 h-125 bg-emerald-100/40 rounded-full blur-3xl -z-10">
        </div>

        <div
            class="w-full max-w-md bg-white border border-gray-100 p-8 md:p-10 rounded-3xl shadow-xl shadow-gray-200/50 space-y-6">

            <!-- Encabezado e Instrucción de la Tarjeta -->
            <div class="text-center space-y-2">
                <div
                    class="w-12 h-12 bg-emerald-50 text-[#10b981] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">¿Olvidaste tu contraseña?</h1>
                <p class="text-sm text-gray-500 leading-relaxed">
                    No te preocupes. Introduce tu correo electrónico y te enviaremos un enlace seguro para restablecerla.
                </p>
            </div>

            <!-- Alertas de estado de Laravel -->
            @if (session('status'))
                <div
                    class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800 font-medium">
                    <svg class="w-5 h-5 text-[#10b981] shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif
            @error('error')
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
                    {{ $message }}
                </div>
            @enderror

            <!-- Formulario de Recuperación -->
            <form id="forgot-password-form" method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Campo de Email -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email" placeholder="nombre@empresa.com"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none 
                            focus:border-[#10b981] focus:bg-white transition-all placeholder:text-gray-400 " />

                    </div>

                    <!-- Mensajes de Error de Validación -->
                    @error('email')
                        <p class="text-xs font-semibold text-red-500 mt-1 flex items-center gap-1">
                            ⚠️ {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Botón de Envío -->
                <button type="submit" id="submit-button"
                    class="w-full px-5 py-3.5 rounded-xl bg-[#22c55e] text-white font-bold text-sm shadow-lg shadow-emerald-100 
                    hover:bg-[#16a34a] hover:shadow-none transition-all uppercase tracking-wider">
                    Enviar Enlace de Recuperación
                </button>
            </form>

            <!-- Retorno al Login -->
            <div class="text-center pt-2">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-[#10b981] hover:text-emerald-700 transition-colors group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Iniciar Sesión
                </a>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/forgot-password.js')
@endpush
