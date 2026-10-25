@extends('layouts.app')

@section('title', 'Panel de Control - ZendTicket')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-10">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800 font-medium">
                <x-heroicon-o-check-circle class="w-5 h-5 shrink-0 text-emerald-500" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if (auth()->user()->hasRole('customer'))
            <header class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-[#10b981]">
                        Mi soporte
                    </p>
                    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900">
                        Hola, {{ auth()->user()->name }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">
                        Consulta el estado de tus solicitudes o reporta un nuevo problema.
                    </p>
                </div>

                @can('create', App\Models\Ticket::class)
                    <a href="{{ route('tickets.create') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#22c55e] text-white text-sm font-bold shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all no-underline">
                        <x-heroicon-o-plus class="w-4 h-4" />
                        Nueva solicitud
                    </a>
                @endcan
            </header>

            <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                <article class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm shadow-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-600">
                            <x-heroicon-o-inbox class="w-5 h-5" />
                        </span>
                        <span class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $summary['open'] }}</span>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-gray-900">Abiertos</p>
                    <p class="mt-1 text-xs text-gray-500">Solicitudes pendientes de atención.</p>
                </article>

                <article class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm shadow-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-50 text-amber-600">
                            <x-heroicon-o-arrow-path class="w-5 h-5" />
                        </span>
                        <span class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $summary['in_progress'] }}</span>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-gray-900">En proceso</p>
                    <p class="mt-1 text-xs text-gray-500">Solicitudes que están siendo gestionadas.</p>
                </article>

                <article class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm shadow-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600">
                            <x-heroicon-o-check-circle class="w-5 h-5" />
                        </span>
                        <span class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $summary['finished'] }}</span>
                    </div>
                    <p class="mt-4 text-sm font-semibold text-gray-900">Finalizados</p>
                    <p class="mt-1 text-xs text-gray-500">Solicitudes resueltas o cerradas.</p>
                </article>
            </section>

            <section class="mt-6 bg-white border border-gray-200 rounded-2xl shadow-sm shadow-gray-100 overflow-hidden">
                <div class="flex items-center justify-between gap-4 px-5 sm:px-6 py-5 border-b border-gray-100">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Solicitudes recientes</h2>
                        <p class="mt-1 text-xs text-gray-500">Tus últimas solicitudes de soporte.</p>
                    </div>

                    <a href="{{ route('tickets.index') }}"
                        class="text-xs font-bold text-[#10b981] hover:text-[#059669] transition-colors no-underline">
                        Ver todas
                    </a>
                </div>

                @forelse ($recentTickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}"
                        class="flex items-center justify-between gap-4 px-5 sm:px-6 py-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors no-underline">
                        <div class="min-w-0">
                            <p class="text-[11px] font-bold tracking-wide text-[#10b981]">
                                {{ $ticket->ticket_number }}
                            </p>
                            <p class="mt-1 text-sm font-semibold text-gray-900 truncate">
                                {{ $ticket->subject }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            @include('tickets.partials.status-badge', ['status' => $ticket->status])
                            <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-300" />
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center">
                        <span class="mx-auto flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 text-gray-400">
                            <x-heroicon-o-ticket class="w-6 h-6" />
                        </span>
                        <p class="mt-4 text-sm font-semibold text-gray-900">Aún no tienes solicitudes</p>
                        <p class="mt-1 text-sm text-gray-500">Cuando reportes un problema aparecerá aquí.</p>
                    </div>
                @endforelse
            </section>
        @endif
    </div>
@endsection
