<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\TicketActivity;
use App\Models\User;

class RecordTicketActivityAction
{
    public function execute(
        Ticket $ticket,
        ?User $user,
        string $action,
        ?array $oldValues = null,
        ?array $newValues = null
    ): TicketActivity {
        return $ticket->activities()->create([
            'user_id' => $user?->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
