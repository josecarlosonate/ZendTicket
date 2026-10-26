<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (! $user->hasRole('customer')) {
            return view('dashboard');
        }

        $tickets = Ticket::query()
            ->where('requester_id', $user->id);

        $summary = [
            'open' => (clone $tickets)->whereHas('status', fn ($query) => $query->where('code', 'open'))->count(),
            'in_progress' => (clone $tickets)->whereHas('status', fn ($query) => $query->where('code', 'in_progress'))->count(),
            'finished' => (clone $tickets)->whereHas(
                'status',
                fn ($query) => $query->whereIn('code', ['resolved', 'closed'])
            )->count(),
        ];

        $recentTickets = (clone $tickets)
            ->with('status')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact('summary', 'recentTickets'));
    }
}
