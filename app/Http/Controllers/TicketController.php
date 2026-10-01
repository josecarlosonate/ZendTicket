<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Priority;
use App\Models\Ticket;
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
}
