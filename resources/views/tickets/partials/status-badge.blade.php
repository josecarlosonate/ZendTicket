@php
    $code = $status->code ?? '';
@endphp

<span @class([
    'inline-flex items-center gap-1.5 whitespace-nowrap px-2.5 py-1 rounded-full text-[11px] font-semibold ring-1 ring-inset',
    'bg-sky-50 text-sky-700 ring-sky-200' => $code === 'open',
    'bg-amber-50 text-amber-700 ring-amber-200' => $code === 'in_progress',
    'bg-emerald-50 text-emerald-700 ring-emerald-200' => $code === 'resolved',
    'bg-gray-100 text-gray-600 ring-gray-200' => $code === 'closed',
    'bg-slate-50 text-slate-600 ring-slate-200' => !in_array(
        $code,
        ['open', 'in_progress', 'resolved', 'closed'],
        true),
])>
    <span @class([
        'w-1.5 h-1.5 rounded-full',
        'bg-sky-500' => $code === 'open',
        'bg-amber-500' => $code === 'in_progress',
        'bg-emerald-500' => $code === 'resolved',
        'bg-gray-400' =>
            $code === 'closed' ||
            !in_array($code, ['open', 'in_progress', 'resolved'], true),
    ])></span>
    {{ $status->name }}
</span>
