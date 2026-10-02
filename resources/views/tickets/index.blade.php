@extends('layouts.app')

@section('title', 'Tickets - ZendTicket')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- Encabezado --}}
        <header class="flex items-start justify-between gap-6 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Tickets
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Consulta y gestiona las solicitudes disponibles para tu usuario.
                </p>
            </div>

            @can('create', App\Models\Ticket::class)
                <a href="{{ route('tickets.create') }}"
                    class="bg-[#22c55e] text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-emerald-100 hover:bg-[#16a34a] 
                    transition-all flex items-center gap-2 no-underline">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    Nueva solicitud
                </a>
            @endcan
        </header>

        {{-- Tabla --}}
        <div class="border border-gray-200 rounded-xl overflow-hidden bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Ticket
                            </th>

                            @canany(['tickets.view_assigned', 'tickets.view_all'])
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    Solicitante
                                </th>
                            @endcanany

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Departamento
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Prioridad
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Fecha
                            </th>

                            <th class="px-6 py-4">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition">
                                {{-- Ticket --}}
                                <td class="px-6 py-5">
                                    <div class="min-w-56">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                            class="text-sm font-semibold text-gray-900 hover:text-emerald-600 transition">
                                            {{ $ticket->subject }}
                                        </a>

                                        <p class="mt-1 text-xs font-medium text-emerald-600">
                                            {{ $ticket->ticket_number }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Solicitante --}}
                                @canany(['tickets.view_assigned', 'tickets.view_all'])
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-gray-700">
                                            {{ $ticket->requester->name }}
                                        </span>
                                    </td>
                                @endcanany

                                {{-- Departamento --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm text-gray-700">
                                        {{ $ticket->department->name }}
                                    </span>
                                </td>

                                {{-- Prioridad --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $ticket->priority->name }}
                                    </span>
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-xs font-semibold text-emerald-700">
                                        {{ $ticket->status->name }}
                                    </span>
                                </td>

                                {{-- Fecha --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="text-sm text-gray-500">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                    </span>
                                </td>

                                {{-- Acción --}}
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('tickets.show', $ticket) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition"
                                        title="Ver ticket">
                                        <x-heroicon-o-chevron-right class="w-5 h-5" />
                                        <span class="sr-only">Ver ticket</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-4">
                                            <x-heroicon-o-ticket class="w-6 h-6 text-gray-400" />
                                        </div>

                                        <h2 class="text-sm font-semibold text-gray-900">
                                            No hay tickets disponibles
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-500">
                                            No tienes solicitudes para mostrar en este momento.
                                        </p>

                                        @can('create', App\Models\Ticket::class)
                                            <a href="{{ route('tickets.create') }}"
                                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                                                <x-heroicon-o-plus class="w-4 h-4" />
                                                Crear primera solicitud
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if ($tickets->hasPages())
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @endif

    </div>
@endsection
