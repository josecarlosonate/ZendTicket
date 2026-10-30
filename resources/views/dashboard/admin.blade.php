@extends('layouts.app')

@section('title', 'Administración - ZendTicket')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
        <header class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Administración</p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900">Panel general</h1>
                <p class="mt-2 text-sm text-gray-600">Resumen de la plataforma y su actividad reciente.</p>
            </div>
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800 transition-colors">
                <x-heroicon-o-ticket class="w-4 h-4" /> Gestionar tickets
            </a>
        </header>

        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Tickets activos', 'value' => $summary['active'], 'description' => 'Abiertos y en proceso', 'color' => 'bg-emerald-500'],
                ['label' => 'Sin asignar', 'value' => $summary['unassigned'], 'description' => 'Abiertos sin agente', 'color' => 'bg-rose-500'],
                ['label' => 'Usuarios activos', 'value' => $summary['active_users'], 'description' => 'Cuentas habilitadas', 'color' => 'bg-sky-500'],
                ['label' => 'Tickets cerrados', 'value' => $summary['closed'], 'description' => 'Total histórico', 'color' => 'bg-slate-500'],
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
                <h2 class="text-sm font-bold text-gray-900">Administración de ZendTicket</h2>
                <p class="mt-1 text-xs text-gray-600">Los módulos de usuarios, roles y catálogos se habilitarán cuando estén implementados.</p>
            </div>
            <div class="p-5 sm:p-6">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50/50 px-5 py-4 text-sm font-semibold text-emerald-800 hover:bg-emerald-100 transition-colors">
                    <x-heroicon-o-ticket class="w-5 h-5" />
                    Gestión de tickets
                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                </a>
            </div>
        </section>

        <section class="mt-6 rounded-2xl border border-emerald-100 bg-white/90 shadow-sm shadow-emerald-900/5 overflow-hidden">
            <div class="border-b border-emerald-100 bg-emerald-50/60 px-5 sm:px-6 py-5">
                <h2 class="text-sm font-bold text-gray-900">Actividad reciente</h2>
                <p class="mt-1 text-xs text-gray-600">Últimas acciones registradas en el historial de tickets.</p>
            </div>
            @forelse ($recentActivities as $activity)
                <a href="{{ route('tickets.show', $activity->ticket) }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-emerald-50 last:border-0 px-5 sm:px-6 py-4 hover:bg-emerald-50/50 transition-colors">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900">{{ $activity->ticket->ticket_number }} · {{ match ($activity->action) {
                            'assigned' => 'Asignación',
                            'reassigned' => 'Reasignación',
                            'resolved' => 'Resolución',
                            'reopened' => 'Reapertura',
                            'closed' => 'Cierre',
                            default => ucfirst(str_replace('_', ' ', $activity->action)),
                        } }}</p>
                        <p class="mt-1 text-xs text-gray-500 truncate">{{ $activity->ticket->subject }} · {{ $activity->user?->name ?? 'Sistema' }}</p>
                    </div>
                    <time class="text-xs text-gray-500 shrink-0" datetime="{{ $activity->created_at->toIso8601String() }}">{{ $activity->created_at->format('d/m/Y H:i') }}</time>
                </a>
            @empty
                <p class="px-6 py-10 text-center text-sm text-gray-500">Todavía no hay actividad registrada.</p>
            @endforelse
        </section>
    </main>
@endsection
