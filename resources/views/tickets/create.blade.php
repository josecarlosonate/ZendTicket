@extends('layouts.app')

@section('title', 'Crear nueva solicitud - ZendTicket')

@section('content')
    <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
        <header class="mb-7">
            <a href="{{ route('tickets.index') }}"
                class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-700 hover:text-emerald-900 transition-colors no-underline">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver a mis solicitudes
            </a>

            <div class="mt-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">
                    Nueva solicitud
                </p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900">
                    Crear ticket
                </h1>
                <p class="mt-2 text-sm text-gray-600 max-w-2xl">
                    Describe el problema con el mayor detalle posible para que el equipo de soporte pueda ayudarte.
                </p>
            </div>
        </header>

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 text-sm text-red-700 font-medium">
                <x-heroicon-o-exclamation-circle class="w-5 h-5 shrink-0 text-red-500" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <section class="bg-white/90 border border-emerald-100 rounded-2xl shadow-sm shadow-emerald-900/5 overflow-hidden">
            <div class="px-5 sm:px-7 py-5 bg-emerald-50/60 border-b border-emerald-100">
                <h2 class="text-sm font-semibold text-gray-900">Detalles de la solicitud</h2>
                <p class="mt-1 text-xs text-gray-600">Los campos marcados son necesarios para registrar tu ticket.</p>
            </div>

            <form method="POST" action="{{ route('tickets.store') }}" class="p-5 sm:p-7 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-2">
                        <label for="department_id" class="text-xs font-bold uppercase tracking-wider text-gray-600">
                            Departamento <span class="text-emerald-700">*</span>
                        </label>
                        <select name="department_id" id="department_id" required
                            class="w-full bg-emerald-50/40 border border-emerald-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 focus:bg-white transition-all cursor-pointer text-gray-700">
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
                        @error('department_id')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="category_id" class="text-xs font-bold uppercase tracking-wider text-gray-600">
                            Categoría <span class="text-emerald-700">*</span>
                        </label>
                        <select name="category_id" id="category_id" required disabled
                            data-old-category="{{ old('category_id') }}"
                            class="w-full bg-emerald-50/40 border border-emerald-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 focus:bg-white transition-all cursor-pointer text-gray-700 disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-400 disabled:opacity-70">
                            <option value="" disabled selected>Selecciona primero un departamento</option>
                        </select>
                        @error('category_id')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="priority_id" class="text-xs font-bold uppercase tracking-wider text-gray-600">
                            Prioridad <span class="text-emerald-700">*</span>
                        </label>
                        <select name="priority_id" id="priority_id" required
                            class="w-full bg-emerald-50/40 border border-emerald-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 focus:bg-white transition-all cursor-pointer text-gray-700">
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
                        @error('priority_id')
                            <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="subject" class="text-xs font-bold uppercase tracking-wider text-gray-600">
                        Asunto <span class="text-emerald-700">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        placeholder="Ej. Error de credenciales al iniciar sesión"
                        class="w-full px-4 py-3.5 bg-emerald-50/40 border border-emerald-100 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 focus:bg-white transition-all placeholder:text-gray-400" />
                    @error('subject')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="description" class="text-xs font-bold uppercase tracking-wider text-gray-600">
                        Descripción detallada <span class="text-emerald-700">*</span>
                    </label>
                    <textarea name="description" id="description" rows="6" required
                        placeholder="Explica qué ocurrió, qué esperabas que sucediera y los pasos para reproducir el problema..."
                        class="w-full px-4 py-3.5 bg-emerald-50/40 border border-emerald-100 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 focus:bg-white transition-all placeholder:text-gray-400 min-h-36 resize-y">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs font-semibold text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 pt-5 border-t border-emerald-100">
                    <p class="text-xs text-gray-500">
                        <span class="text-emerald-700 font-semibold">*</span> Campos obligatorios
                    </p>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-3 rounded-xl bg-white border border-emerald-100 text-gray-600 font-bold text-xs hover:bg-emerald-50 transition-all no-underline">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md shadow-emerald-900/10 hover:bg-emerald-700 transition-all cursor-pointer">
                            <x-heroicon-o-paper-airplane class="w-4 h-4" />
                            Crear solicitud
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection

@push('scripts')
    @vite('resources/js/tickets/create.js')
@endpush
