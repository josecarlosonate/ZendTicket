<div class="flex flex-col items-center px-6 py-14 text-center">
    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50 mb-4">
        <x-heroicon-o-ticket class="w-6 h-6 text-[#10b981]" />
    </div>
    <h2 class="text-sm font-semibold text-gray-900">No hay tickets disponibles</h2>
    <p class="mt-1 text-sm text-gray-500 max-w-sm">
        No tienes solicitudes para mostrar en este momento.
    </p>
    @can('create', App\Models\Ticket::class)
        <a href="{{ route('tickets.create') }}"
            class="mt-5 inline-flex items-center gap-2 bg-[#22c55e] text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md shadow-emerald-100 hover:bg-[#16a34a] transition-all no-underline">
            <x-heroicon-o-plus class="w-4 h-4" />
            Crear primera solicitud
        </a>
    @endcan
</div>
