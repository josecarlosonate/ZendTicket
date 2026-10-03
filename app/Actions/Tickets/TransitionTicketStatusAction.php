<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\TicketStatus;
use DomainException;

class TransitionTicketStatusAction
{
    private const TRANSITIONS = [
        'assign' => [
            'open' => 'in_progress',
            'in_progress' => 'in_progress',
        ],
        'resolve' => [
            'in_progress' => 'resolved',
        ],
        'reopen' => [
            'resolved' => 'in_progress',
        ],
        'close' => [
            'resolved' => 'closed',
        ],
    ];

    public function execute(Ticket $ticket, string $action): void
    {
        $currentStatus = $ticket->status->code;

        $nextStatus = self::TRANSITIONS[$action][$currentStatus] ?? null;

        if (! $nextStatus) {
            throw new DomainException(
                "Transición de estado inválida: {$action} desde {$currentStatus}."
            );
        }

        $nextTicketStatus = TicketStatus::where('code', $nextStatus)->firstOrFail();

        $updates = [
            'status_id' => $nextTicketStatus->id,
        ];

        if ($action === 'assign' && is_null($ticket->assigned_at)) {
            $updates['assigned_at'] = now();
        }

        if ($action === 'resolve') {
            $updates['resolved_at'] = now();
        }

        if ($action === 'reopen') {
            $updates['resolved_at'] = null;
        }

        if ($action === 'close') {
            $updates['closed_at'] = now();
        }

        $ticket->update($updates);
    }
}
