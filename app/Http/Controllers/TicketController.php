<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Department;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\TicketSequence;
use App\Models\TicketStatus;
use App\Models\User;
use App\Http\Requests\AssignTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    public function create()
    {
        Gate::authorize('create', Ticket::class);
        $departments = Department::orderBy('name')->get();
        $priorities = Priority::orderBy('name')->get();

        return view('tickets.create', compact(
            'departments',
            'priorities'
        ));
    }

    public function categories(Department $department)
    {
        $categories = $department->categories()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();
        try {
            $ticket = DB::transaction(function () use ($data, $request) {
                $year = now()->year;

                TicketSequence::firstOrCreate(['year' => $year], ['last_number' => 0]);

                $sequence = TicketSequence::where('year', $year)->lockForUpdate()->firstOrFail();
                $sequence->increment('last_number');

                $number = $sequence->last_number;

                // Formato de numero: ZT-2026-000054
                $ticketNumber = sprintf('ZT-%d-%06d', $year, $number);

                $openStatus = TicketStatus::where('code', 'open')->firstOrFail();

                return Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'requester_id' => $request->user()->id,
                    'department_id' => $data['department_id'],
                    'category_id' => $data['category_id'],
                    'priority_id' => $data['priority_id'],
                    'status_id' => $openStatus->id,
                    'subject' => $data['subject'],
                    'description' => $data['description'],
                ]);
            });

            return redirect()->route('tickets.show', $ticket)
                ->with('success', "Ticket {$ticket->ticket_number} creado correctamente.");
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withInput()
                ->with('error', 'No fue posible crear el ticket. Inténtalo nuevamente.');
        }
    }

    public function show(Request $request, Ticket $ticket)
    {
        Gate::authorize('view', $ticket);
        $ticket->load([
            'requester',
            'assignee',
            'department',
            'category',
            'priority',
            'status',
        ]);

        $agents = collect();

        if ($request->user()->can('tickets.assign')) {
            $agents = User::active()
                ->role('agent')
                ->orderBy('name')
                ->get();
        }

        return view('tickets.show', compact('ticket', 'agents'));
    }

    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->visibleTo($request->user())->with(['requester', 'department', 'priority', 'status'])
            ->latest()
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function assign(AssignTicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();

        $ticket->update([
            'assigned_to' => $data['agent_id'],
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Agente asignado correctamente.');
    }
}
