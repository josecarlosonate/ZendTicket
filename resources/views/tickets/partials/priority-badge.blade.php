@php
    $level = (int) ($priority->level ?? 0);
@endphp

<span @class([
    'inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold uppercase tracking-wide',
    'bg-slate-100 text-slate-600' => $level <= 1,
    'bg-sky-50 text-sky-700' => $level === 2,
    'bg-orange-50 text-orange-700' => $level === 3,
    'bg-rose-50 text-rose-700' => $level >= 4,
])>
    {{ $priority->name }}
</span>
