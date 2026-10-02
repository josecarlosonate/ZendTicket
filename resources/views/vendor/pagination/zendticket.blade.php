@if ($paginator->total() > 0)
    <nav role="navigation" aria-label="Paginación" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500">
            Mostrando
            <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
        </p>

        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-300">
                    <x-heroicon-o-chevron-left class="w-4 h-4" />
                    Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:border-[#10b981] hover:text-[#10b981] transition no-underline">
                    <x-heroicon-o-chevron-left class="w-4 h-4" />
                    Anterior
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center justify-center w-9 h-9 text-sm text-gray-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"
                                class="inline-flex items-center justify-center min-w-9 h-9 px-2 rounded-xl bg-[#22c55e] text-sm font-bold text-white shadow-md shadow-emerald-100">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="inline-flex items-center justify-center min-w-9 h-9 px-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:border-[#10b981] hover:text-[#10b981] transition no-underline">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:border-[#10b981] hover:text-[#10b981] transition no-underline">
                    Siguiente
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-300">
                    Siguiente
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                </span>
            @endif
        </div>
    </nav>
@endif
