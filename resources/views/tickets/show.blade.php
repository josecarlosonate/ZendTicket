@extends('layouts.app')

@section('title', $ticket->ticket_number . ' - ZendTicket')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-10">

        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800">
                <x-heroicon-o-check-circle class="w-5 h-5 shrink-0 text-emerald-500" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 text-sm text-red-700">
                <x-heroicon-o-exclamation-circle class="w-5 h-5 shrink-0 text-red-500" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-[#10b981] transition-colors">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Volver al Panel
            </a>
        </div>

        <header class="relative z-40 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between mb-6">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                    <span class="text-[11px] font-bold tracking-wide text-[#10b981]">
                        {{ $ticket->ticket_number }}
                    </span>
                    @include('tickets.partials.status-badge', ['status' => $ticket->status])
                </div>

                <h1 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    {{ $ticket->subject }}
                </h1>

                <p class="mt-3 flex flex-wrap items-center gap-2 text-sm text-gray-500">
                    <span
                        class="flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-[11px] font-bold text-gray-600">
                        {{ strtoupper(mb_substr($ticket->requester->name, 0, 1)) }}
                    </span>
                    <span>
                        Creado por
                        <span class="font-medium text-gray-700">{{ $ticket->requester->name }}</span>
                    </span>
                    <span class="text-gray-300">·</span>
                    <time datetime="{{ $ticket->created_at->toIso8601String() }}">
                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </time>
                </p>
            </div>

            @can('tickets.assign')
                <div class="relative shrink-0">
                    <button id="assignmentButton" type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-colors cursor-pointer shadow-sm">
                        <x-heroicon-o-user-plus class="w-4 h-4" />
                        {{ $ticket->assignee ? 'Reasignar agente' : 'Asignar agente' }}
                    </button>

                    <div id="assignmentForm" @class([
                        'absolute right-0 top-full mt-3 z-50 w-80 max-w-[calc(100vw-2rem)] bg-white border border-gray-200 rounded-2xl shadow-xl p-5',
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

                            <label for="agent_id" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-500">
                                Agente
                            </label>

                            <select id="agent_id" name="agent_id" @class([
                                'w-full bg-gray-50 border rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:bg-white transition-all cursor-pointer',
                                'border-red-300 focus:border-red-500' => $errors->has('agent_id'),
                                'border-gray-200 focus:border-[#10b981]' => !$errors->has('agent_id'),
                            ])>
                                <option value="">Selecciona un agente</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @selected(old('agent_id', $ticket->assigned_to) == $agent->id)>
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('agent_id')
                                <p class="mt-2 text-xs font-semibold text-red-500">{{ $message }}</p>
                            @enderror

                            <div class="flex justify-end gap-2 mt-5">
                                <button id="cancelAssignment" type="button"
                                    class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 cursor-pointer">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-[#22c55e] text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all cursor-pointer">
                                    Asignar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
        </header>

        <section class="relative z-30 border border-gray-200 rounded-2xl bg-white shadow-sm shadow-gray-100 overflow-visible">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                <div class="px-5 py-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Departamento</p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-gray-800">
                        <x-heroicon-o-building-office-2 class="w-4 h-4 text-gray-400" />
                        {{ $ticket->department->name }}
                    </p>
                </div>

                <div class="px-5 py-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Categoría</p>
                    <p class="mt-2 text-sm font-medium text-gray-800">
                        {{ $ticket->category->name }}
                    </p>
                </div>

                <div class="relative z-20 px-5 py-4 overflow-visible">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Prioridad</p>
                    <div class="flex items-center gap-2 mt-2">
                        @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])

                        @can('changePriority', $ticket)
                            <button id="priorityButton" type="button"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-emerald-50 hover:text-[#10b981] transition-colors cursor-pointer"
                                title="Cambiar prioridad">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </button>
                        @endcan
                    </div>

                    @can('changePriority', $ticket)
                        <div id="priorityForm" @class([
                            'absolute left-0 top-full mt-3 z-40 w-72 max-w-[calc(100vw-2rem)] bg-white border border-gray-200 rounded-2xl shadow-xl p-5',
                            'hidden' => !$errors->has('priority_id'),
                        ])>
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-gray-900">Cambiar prioridad</h3>
                                <p class="mt-1 text-xs text-gray-500">
                                    Selecciona la nueva prioridad del ticket.
                                </p>
                            </div>

                            <form action="{{ route('tickets.priority.update', $ticket) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <label for="priority_id" class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Prioridad
                                </label>

                                <select id="priority_id" name="priority_id" @class([
                                    'w-full bg-gray-50 border rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:bg-white transition-all cursor-pointer',
                                    'border-red-300 focus:border-red-500' => $errors->has('priority_id'),
                                    'border-gray-200 focus:border-[#10b981]' => !$errors->has('priority_id'),
                                ])>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}" @selected(old('priority_id', $ticket->priority_id) == $priority->id)>
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('priority_id')
                                    <p class="mt-2 text-xs font-semibold text-red-500">{{ $message }}</p>
                                @enderror

                                <div class="flex justify-end gap-2 mt-5">
                                    <button id="cancelPriority" type="button"
                                        class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 cursor-pointer">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-[#22c55e] text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all cursor-pointer">
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endcan
                </div>

                <div class="px-5 py-4">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Agente asignado</p>
                    <p class="mt-2 inline-flex items-center gap-2 text-sm font-medium text-gray-800">
                        @if ($ticket->assignee)
                            <span
                                class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-[11px] font-bold text-emerald-700">
                                {{ strtoupper(mb_substr($ticket->assignee->name, 0, 1)) }}
                            </span>
                            {{ $ticket->assignee->name }}
                        @else
                            <span class="text-gray-400 font-normal">Sin asignar</span>
                        @endif
                    </p>
                </div>
            </div>
        </section>

        <section class="mt-6 border border-gray-200 rounded-2xl bg-white shadow-sm shadow-gray-100 px-5 sm:px-6 py-6">
            <h2 class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-4">Descripción</h2>
            <div class="text-sm text-gray-700 leading-7 whitespace-pre-line">
                {{ $ticket->description }}
            </div>
        </section>

        <section class="mt-6 border border-gray-200 rounded-2xl bg-white shadow-sm shadow-gray-100 px-5 sm:px-6 py-6">
            <h2 class="text-sm font-semibold text-gray-900">Conversación</h2>
            <div class="mt-5 flex flex-col items-center px-6 py-10 text-center">
                <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 mb-4">
                    <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-[#10b981]" />
                </div>
                <p class="text-sm font-semibold text-gray-900">Aún no hay respuestas</p>
                <p class="mt-1 text-sm text-gray-500">Este ticket todavía no tiene mensajes en la conversación.</p>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/tickets/show.js')
@endpush
