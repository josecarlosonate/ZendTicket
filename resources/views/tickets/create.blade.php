@extends('layouts.app')

@section('title', 'Crear nuevo ticket - ZendTicket')

@section('content')

    <main class="grow p-5 md:p-8 flex justify-center items-start bg-slate-50 min-h-screen">
        <section
            class="w-full max-w-3xl bg-white border border-gray-100 p-6 md:p-10 rounded-3xl shadow-xl shadow-gray-200/50 space-y-8">

            <!-- Encabezado del Formulario -->
            <header class="border-b border-gray-50 pb-5 space-y-2">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-emerald-50 text-[#10b981] rounded-xl flex items-center justify-center shadow-inner">
                        <x-heroicon-o-plus class="w-5 h-5" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Crear ticket</h1>
                        <p class="text-sm text-gray-400 font-medium">Describe el problema o solicitud que necesitas reportar
                            al equipo técnico.</p>
                    </div>
                </div>
            </header>

            <!-- Formulario con Directivas Blade de Laravel -->
            <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                @csrf

                <!-- Grid para los Selects (Responsivo: 1 columna en móviles, 3 columnas en pantallas medianas) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <!-- Departamento -->
                    <div class="space-y-2">
                        <label for="department_id"
                            class="text-xs font-bold uppercase tracking-wider text-gray-500">Departamento</label>
                        <div class="relative">
                            <select name="department_id" id="department_id" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#10b981] 
                                focus:bg-white transition-all cursor-pointer text-gray-700">
                                <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>
                                    Selecciona un departamento
                                </option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('department_id')
                            <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="space-y-2">
                        <label for="category_id"
                            class="text-xs font-bold uppercase tracking-wider text-gray-500">Categoría</label>
                        <div class="relative">
                            <select name="category_id" id="category_id" required disabled
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#10b981] 
                                focus:bg-white transition-all cursor-pointer text-gray-700 
                                disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400 disabled:opacity-70">
                                <option value="" disabled selected>Selecciona primero un departamento</option>
                            </select>
                        </div>
                        @error('category_id')
                            <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prioridad -->
                    <div class="space-y-2">
                        <label for="priority_id" class="text-xs font-bold uppercase tracking-wider text-gray-500">
                            Prioridad
                        </label>
                        <div class="relative">
                            <select name="priority_id" id="priority_id" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#10b981] 
                                focus:bg-white transition-all cursor-pointer text-gray-700">
                                <option value="" disabled {{ old('priority_id') ? '' : 'selected' }}>
                                    Selecciona una prioridad
                                </option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}"
                                        {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                                        {{ $priority->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('priority_id')
                            <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Asunto -->
                <div class="space-y-2">
                    <label for="subject" class="text-xs font-bold uppercase tracking-wider text-gray-500">Asunto</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        placeholder="Ej. Error de credenciales en el login del sistema"
                        class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] 
                        focus:bg-white transition-all placeholder:text-gray-400" />
                    @error('subject')
                        <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="space-y-2">
                    <label for="description" class="text-xs font-bold uppercase tracking-wider text-gray-500">Descripción
                        detallada</label>
                    <textarea name="description" id="description" rows="5" required
                        placeholder="Por favor, incluye todos los detalles relevantes y pasos para reproducir el error..."
                        class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#10b981] 
                        focus:bg-white transition-all placeholder:text-gray-400 min-h-30 resize-y">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs font-semibold text-red-500 mt-1">⚠️ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Acciones / Botones -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-3 rounded-xl bg-gray-100 text-gray-600 font-bold text-xs hover:bg-gray-200 
                        transition-all uppercase tracking-wider">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-[#22c55e] text-white font-bold text-xs shadow-lg shadow-emerald-100
                         hover:bg-[#16a34a] hover:shadow-none transition-all uppercase tracking-wider">
                        Crear ticket
                    </button>
                </div>
            </form>
        </section>
    </main>

@endsection

@push('scripts')
    @vite('resources/js/tickets/create.js')
@endpush
