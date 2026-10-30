<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketActivity;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin') && $user->can('tickets.view_all')) {
            $tickets = Ticket::query()->visibleTo($user);

            $summary = [
                'active' => (clone $tickets)->whereHas('status', fn ($query) => $query->whereIn('code', ['open', 'in_progress']))->count(),
                'unassigned' => (clone $tickets)->whereNull('assigned_to')->whereHas('status', fn ($query) => $query->where('code', 'open'))->count(),
                'active_users' => User::active()->count(),
                'closed' => (clone $tickets)->whereHas('status', fn ($query) => $query->where('code', 'closed'))->count(),
            ];

            $recentActivities = TicketActivity::query()
                ->with(['ticket', 'user'])
                ->whereHas('ticket', fn ($query) => $query->visibleTo($user))
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard.admin', compact('summary', 'recentActivities'));
        }

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
