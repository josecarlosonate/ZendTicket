@extends('layouts.app')

@section('title', $ticket->ticket_number . ' - ZendTicket')

@section('content')

    <div class="max-w-7xl mx-auto px-8 py-10">

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800">
                <x-heroicon-o-check-circle class="w-5 h-5 shrink-0 text-emerald-500" />
                <span>
                    {{ session('success') }}
                </span>
            </div>
        @endif

        {{-- Navegación --}}
        <div class="mb-8">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-[#10b981] transition-colors group">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver al Panel
            </a>
        </div>

        {{-- Cabecera del ticket --}}
        <header class="flex items-start justify-between gap-8 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-sm font-semibold text-emerald-600">
                        {{ $ticket->ticket_number }}
                    </span>

                    <span
                        class="px-2.5 py-1 rounded-md bg-emerald-50 border text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider">
                        {{ $ticket->status->name }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    {{ $ticket->subject }}
                </h1>

                <p class="mt-3 text-sm text-gray-500">
                    Creado por
                    <span class="font-medium text-gray-700">
                        {{ $ticket->requester->name }}
                    </span>
                    ·
                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            @can('tickets.assign')
                <div class="relative">
                    <button id="assignmentButton" type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white
                                text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-user-plus class="w-4 h-4" />
                        {{ $ticket->assignee ? 'Reasignar agente' : 'Asignar agente' }}
                    </button>

                    <div id="assignmentForm" @class([
                        'absolute right-0 top-full mt-3 z-20 w-80 bg-white border border-gray-200 rounded-xl shadow-lg p-5',
                        'hidden' => !$errors->has('agent_id'),
                    ])>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-900">
                                {{ $ticket->assignee ? 'Reasignar agente' : 'Asignar agente' }}
                            </h3>

                            <p class="mt-1 text-xs text-gray-500">
                                Selecciona el agente responsable del ticket.
                            </p>
                        </div>

                        <form action="{{ route('tickets.assign', $ticket) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <label for="agent_id" class="block mb-2 text-xs font-semibold text-gray-500">
                                Agente
                            </label>

                            <select id="agent_id" name="agent_id" @class([
                                'w-full rounded-lg text-sm',
                                'border-red-300 focus:border-red-500 focus:ring-red-500' => $errors->has(
                                    'agent_id'),
                                'border-gray-300 focus:border-emerald-500 focus:ring-emerald-500' => !$errors->has(
                                    'agent_id'),
                            ])>
                                <option value="">Selecciona un agente</option>

                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected(old('agent_id', $ticket->assigned_to) == $agent->id)>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('agent_id')
                                <p class="mt-2 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                            <div class="flex justify-end gap-2 mt-5">
                                <button id="cancelAssignment" type="button"
                                    class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                                    Cancelar
                                </button>

                                <button type="submit"
                                    class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold
                                    rounded-lg hover:bg-emerald-700 transition-colors cursor-pointer">
                                    Asignar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan

        </header>

        {{-- Información general --}}
        <section class="border-y border-gray-200 py-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Departamento
                    </p>

                    <p class="mt-2 text-sm font-medium text-gray-800">
                        {{ $ticket->department->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Categoría
                    </p>

                    <p class="mt-2 text-sm font-medium text-gray-800">
                        {{ $ticket->category->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Prioridad
                    </p>

                    <p class="mt-2 text-sm font-medium text-gray-800">
                        {{ $ticket->priority->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Agente asignado
                    </p>

                    <p class="mt-2 text-sm font-medium text-gray-800">
                        {{ $ticket->assignee?->name ?? 'Sin asignar' }}
                    </p>
                </div>

            </div>
        </section>

        {{-- Descripción --}}
        <section class="py-10 border-b border-gray-200">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-5">
                Descripción
            </h2>

            <div class="text-gray-700 leading-7 whitespace-pre-line">
                {{ $ticket->description }}
            </div>
        </section>

        {{-- Conversación --}}
        <section class="py-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Conversación
                </h2>
            </div>

            <p class="text-sm text-gray-400">
                Aún no hay respuestas en este ticket.
            </p>
        </section>

    </div>

@endsection

@push('scripts')
    @vite('resources/js/tickets/show.js')
@endpush
