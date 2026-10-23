<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketCommentRequest;
use App\Models\Ticket;

class TicketCommentController extends Controller
{
    public function store(StoreTicketCommentRequest $request, Ticket $ticket)
    {
        $data = $request->validated();

        $ticket->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'is_internal' => true,
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Nota interna agregada correctamente.');
    }
}
