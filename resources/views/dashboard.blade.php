@extends('layouts.app')

@section('title', 'Panel de Control - ZendTicket')

@section('content')
    @if (session('success'))
        <div
            class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800 font-medium">
            <svg class="w-5 h-5 text-[#10b981] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
            {{ session('error') }}
        </div>
    @endif
@endsection
