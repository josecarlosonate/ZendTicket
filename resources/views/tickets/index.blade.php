@extends('layouts.app')

@section('title', 'Tickets - ZendTicket')

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
            <div
                class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 text-sm text-red-700">
                <x-heroicon-o-exclamation-circle class="w-5 h-5 shrink-0 text-red-500" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <header class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between mb-8">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-[#10b981]">
                    Bandeja
                </p>
                <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900">
                    Tickets
                </h1>
                <p class="mt-2 text-sm text-gray-500 max-w-xl">
                    @if (auth()->user()->hasRole('customer'))
                        Consulta el estado de las solicitudes que has enviado.
                    @else
                        Consulta y gestiona las solicitudes disponibles para tu usuario.
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                @unless (auth()->user()->hasRole('customer'))
                    <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-gray-200 text-sm text-gray-600">
                        <x-heroicon-o-ticket class="w-4 h-4 text-[#10b981]" />
                        <span class="font-semibold text-gray-900">{{ $tickets->total() }}</span>
                        <span>{{ $tickets->total() === 1 ? 'solicitud' : 'solicitudes' }}</span>
                    </div>
                @endunless

                @can('create', App\Models\Ticket::class)
                    <a href="{{ route('tickets.create') }}"
                        class="bg-[#22c55e] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all flex items-center gap-2 no-underline">
                        <x-heroicon-o-plus class="w-4 h-4" />
                        Nueva solicitud
                    </a>
                @endcan
            </div>
        </header>

        <div class="border border-gray-200 rounded-2xl overflow-hidden bg-white shadow-sm shadow-gray-100">
            <div class="flex items-center justify-between gap-4 px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/70">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Solicitudes recientes</h2>
                    <p class="mt-0.5 text-xs text-gray-500">
                        Ordenadas de la más nueva a la más antigua.
                    </p>
                </div>
                @if ($tickets->hasPages())
                    <p class="text-xs font-medium text-gray-400">
                        Página {{ $tickets->currentPage() }} de {{ $tickets->lastPage() }}
                    </p>
                @endif
            </div>

            {{-- Lista móvil --}}
            <div class="md:hidden divide-y divide-gray-100">
                @forelse ($tickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}"
                        class="block px-5 py-4 hover:bg-gray-50 transition no-underline">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold tracking-wide text-[#10b981]">
                                    {{ $ticket->ticket_number }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 truncate">
                                    {{ $ticket->subject }}
                                </p>
                            </div>
                            <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-300 shrink-0 mt-1" />
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            @include('tickets.partials.status-badge', ['status' => $ticket->status])
                            @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])
                        </div>

                        <div class="mt-3 flex items-center justify-between gap-3 text-xs text-gray-500">
                            <span class="truncate">{{ $ticket->department->name }}</span>
                            <time datetime="{{ $ticket->created_at->toIso8601String() }}" title="{{ $ticket->created_at->format('d/m/Y H:i') }}">
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </time>
                        </div>
                    </a>
                @empty
                    @include('tickets.partials.empty-state')
                @endforelse
            </div>

            {{-- Tabla escritorio --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Ticket</th>
                            @canany(['tickets.view_assigned', 'tickets.view_all'])
                                <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Solicitante</th>
                            @endcanany
                            <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Departamento</th>
                            <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Prioridad</th>
                            <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Estado</th>
                            <th class="px-6 py-3 text-[11px] font-bold uppercase tracking-wider text-gray-400">Fecha</th>
                            <th class="px-6 py-3"><span class="sr-only">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tickets as $ticket)
                            <tr class="group hover:bg-emerald-50/40 transition">
                                <td class="px-6 py-4">
                                    <div class="min-w-56">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                            class="text-sm font-semibold text-gray-900 hover:text-[#10b981] transition">
                                            {{ $ticket->subject }}
                                        </a>
                                        <p class="mt-1 text-[11px] font-bold tracking-wide text-[#10b981]">
                                            {{ $ticket->ticket_number }}
                                        </p>
                                    </div>
                                </td>

                                @canany(['tickets.view_assigned', 'tickets.view_all'])
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5 min-w-40">
                                            <span
                                                class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-[11px] font-bold text-gray-600 shrink-0">
                                                {{ strtoupper(mb_substr($ticket->requester->name, 0, 1)) }}
                                            </span>
                                            <span class="text-sm text-gray-700 truncate">
                                                {{ $ticket->requester->name }}
                                            </span>
                                        </div>
                                    </td>
                                @endcanany

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-700">
                                        <x-heroicon-o-building-office-2 class="w-4 h-4 text-gray-400" />
                                        {{ $ticket->department->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @include('tickets.partials.priority-badge', ['priority' => $ticket->priority])
                                </td>

                                <td class="px-6 py-4">
                                    @include('tickets.partials.status-badge', ['status' => $ticket->status])
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <time class="text-sm text-gray-500"
                                        datetime="{{ $ticket->created_at->toIso8601String() }}"
                                        title="{{ $ticket->created_at->format('d/m/Y H:i') }}">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                    </time>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 group-hover:text-[#10b981] group-hover:bg-white transition"
                                        title="Ver ticket">
                                        <x-heroicon-o-chevron-right class="w-5 h-5" />
                                        <span class="sr-only">Ver ticket</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6">
                                    @include('tickets.partials.empty-state')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($tickets->hasPages())
            <div class="mt-6">
                {{ $tickets->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
@endsection
