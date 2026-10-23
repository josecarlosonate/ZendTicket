<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'is_internal' => $request->boolean('is_internal'),
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Comentario agregado correctamente.');
    }
}
