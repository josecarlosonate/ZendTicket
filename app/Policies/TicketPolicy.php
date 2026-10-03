<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->can('tickets.view_all')) {
            return true;
        }

        if ($user->can('tickets.view_own') && $ticket->requester_id === $user->id) {
            return true;
        }

        if ($user->can('tickets.view_assigned') && $ticket->assigned_to === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('tickets.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }

    public function changePriority(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets.change_priority')
            && in_array($ticket->status->code, ['open', 'in_progress'], true);
    }

    public function resolve(User $user, Ticket $ticket): bool
    {
        if (! $user->can('tickets.resolve')) {
            return false;
        }

        if ($user->hasRole('agent')) {
            return $ticket->assigned_to === $user->id;
        }

        return true;
    }

    public function reopen(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets.reopen');
    }

    public function close(User $user, Ticket $ticket): bool
    {
        return $user->can('tickets.close');
    }
}
