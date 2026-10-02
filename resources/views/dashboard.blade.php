@extends('layouts.app')

@section('title', 'Panel de Control - ZendTicket')

@section('content')
    @if (session('success'))
        <div
            class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3 text-sm text-emerald-800 font-medium">
            <x-heroicon-o-check-circle class="w-5 h-5 shrink-0 text-emerald-500" />
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 font-medium">
            {{ session('error') }}
        </div>
    @endif
@endsection
