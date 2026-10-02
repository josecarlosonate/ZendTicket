<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Priority;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Gate;
use App\Models\TicketSequence;
use Illuminate\Support\Facades\DB;

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

            return redirect()->route('dashboard')
                ->with('success', "Ticket {$ticket->ticket_number} creado correctamente.");
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withInput()
                ->with('error', 'No fue posible crear el ticket. Inténtalo nuevamente.');
        }
    }
}
