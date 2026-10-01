@extends('layouts.guest')

@section('title', 'Restablecer contraseña - ZendTicket')

@section('content')
    <!-- Contenedor Principal -->
    <div class="grow flex items-center justify-center px-6 py-12 relative overflow-hidden">
        <!-- Fondo Decorativo Sutil -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-125 h-125 bg-emerald-100/40 rounded-full blur-3xl -z-10">
        </div>

        <div
            class="w-full max-w-md bg-white border border-gray-100 p-8 md:p-10 rounded-3xl shadow-xl shadow-gray-200/50 space-y-6">

            <!-- Encabezado de la Tarjeta -->
            <div class="text-center space-y-2">
                <div
                    class="w-12 h-12 bg-emerald-50 text-[#10b981] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Nueva Contraseña</h1>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Establece tu nueva credencial de acceso para asegurar tu cuenta de soporte.
                </p>
            </div>

            <!-- Formulario de Actualización -->
            <form method="POST" action="{{ route('') }}" class="space-y-5">
                @csrf

                <!-- Token requerido por Laravel para validar la solicitud de restablecimiento -->
                <input type="hidden" name="token" value="">

                <!-- Campo de Correo Electrónico -->
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
                        <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}"
                            required autocomplete="email" placeholder="admin@empresa.com"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none 
                            focus:border-[#10b981] focus:bg-white transition-all placeholder:text-gray-400" />
                    </div>
                    @error('email')
                        <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo de Nueva Contraseña -->
                <div class="space-y-2">
                    <label for="password" class="text-xs font-bold uppercase tracking-wider text-gray-500">Nueva
                        Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] 
                            focus:bg-white transition-all placeholder:text-gray-400 " />
                    </div>
                    @error('password')
                        <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo de Confirmar Contraseña -->
                <div class="space-y-2">
                    <label for="password_confirmation"
                        class="text-xs font-bold uppercase tracking-wider text-gray-500">Confirmar Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            autocomplete="new-password" placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] focus:bg-white transition-all placeholder:text-gray-400" />
                    </div>
                </div>

                <!-- Botón de Envío -->
                <button type="submit"
                    class="w-full px-5 py-3.5 rounded-xl bg-[#22c55e] text-white font-bold text-sm shadow-lg shadow-emerald-100 hover:bg-[#16a34a] hover:shadow-none transition-all uppercase tracking-wider">
                    Restablecer Contraseña
                </button>
            </form>
        </div>
    </div>
@endsection
