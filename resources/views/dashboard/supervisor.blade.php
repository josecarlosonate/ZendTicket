@extends('layouts.app')

@section('title', 'Supervisión - ZendTicket')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Panel de supervisión</p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900">Resumen de soporte</h1>
                <p class="mt-2 text-sm text-gray-600">Supervisa la carga de trabajo y las solicitudes que necesitan atención.</p>
            </div>
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800 transition-colors">
                <x-heroicon-o-ticket class="w-4 h-4" /> Gestionar tickets
            </a>
        </header>

        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Abiertos', 'value' => $summary['open'], 'color' => 'bg-sky-500', 'description' => 'Pendientes de atención'],
                ['label' => 'En proceso', 'value' => $summary['in_progress'], 'color' => 'bg-amber-500', 'description' => 'En gestión'],
                ['label' => 'Resueltos', 'value' => $summary['resolved'], 'color' => 'bg-emerald-500', 'description' => 'Pendientes de cierre'],
                ['label' => 'Sin asignar', 'value' => $summary['unassigned'], 'color' => 'bg-rose-500', 'description' => 'Abiertos sin agente'],
            ] as $metric)
                <article class="rounded-2xl border border-emerald-100 bg-white/90 p-5 shadow-sm shadow-emerald-900/5">
                    <p class="text-xs font-semibold text-gray-600">{{ $metric['label'] }}</p>
                    <p class="mt-3 text-3xl font-extrabold text-gray-900">{{ $metric['value'] }}</p>
                    <p class="mt-2 text-xs text-gray-500">{{ $metric['description'] }}</p>
                    <div class="mt-4 h-1 w-12 rounded-full {{ $metric['color'] }}"></div>
                </article>
            @endforeach
        </section>

        <section class="mt-6 rounded-2xl border border-emerald-100 bg-white/90 shadow-sm shadow-emerald-900/5 overflow-hidden">
            <div class="border-b border-emerald-100 bg-emerald-50/60 px-5 sm:px-6 py-5">
                <h2 class="text-sm font-bold text-gray-900">Tickets que requieren atención</h2>
                <p class="mt-1 text-xs text-gray-600">Solicitudes activas sin asignar o con prioridad alta/urgente.</p>
            </div>
            @forelse ($needsAttention as $ticket)
                <a href="{{ route('tickets.show', $ticket) }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-emerald-50 last:border-0 px-5 sm:px-6 py-4 hover:bg-emerald-50/50 transition-colors">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-emerald-700">{{ $ticket->ticket_number }}</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 truncate">{{ $ticket->subject }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $ticket->assignee?->name ?? 'Sin asignar' }} · {{ $ticket->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])
                        @include('tickets.partials.status-badge', ['status' => $ticket->status])
                    </div>
                </a>
            @empty
                <p class="px-6 py-10 text-center text-sm text-gray-500">No hay tickets que requieran atención prioritaria.</p>
            @endforelse
        </section>

        <section class="mt-6 rounded-2xl border border-emerald-100 bg-white/90 shadow-sm shadow-emerald-900/5 overflow-hidden">
            <div class="flex items-center justify-between gap-4 border-b border-emerald-100 bg-emerald-50/60 px-5 sm:px-6 py-5">
                <div>
                    <h2 class="text-sm font-bold text-gray-900">Solicitudes recientes</h2>
                    <p class="mt-1 text-xs text-gray-600">Últimos cinco tickets registrados.</p>
                </div>
                <a href="{{ route('tickets.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Ver todas</a>
            </div>
            @forelse ($recentTickets as $ticket)
                <a href="{{ route('tickets.show', $ticket) }}" class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 border-b border-emerald-50 last:border-0 px-5 sm:px-6 py-4 hover:bg-emerald-50/50 transition-colors">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold text-emerald-700">{{ $ticket->ticket_number }}</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 truncate">{{ $ticket->subject }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $ticket->assignee?->name ?? 'Sin asignar' }} · {{ $ticket->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])
                        @include('tickets.partials.status-badge', ['status' => $ticket->status])
                        <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                    </div>
                </a>
            @empty
                <p class="px-6 py-10 text-center text-sm text-gray-500">Todavía no hay solicitudes registradas.</p>
            @endforelse
        </section>
    </main>
@endsection
