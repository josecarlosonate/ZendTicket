<?php

use App\Actions\Tickets\TransitionTicketStatusAction;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(RolesAndPermissionsSeeder::class)->run();

    DB::table('departments')->insert([
        'id' => 1,
        'code' => 'SUPPORT',
        'name' => 'Soporte',
        'description' => null,
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('categories')->insert([
        'id' => 1,
        'code' => 'GENERAL',
        'department_id' => 1,
        'name' => 'General',
        'description' => null,
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('priorities')->insert([
        'id' => 1,
        'name' => 'Normal',
        'level' => 1,
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    foreach ([
        'open' => 'Abierto',
        'in_progress' => 'En progreso',
        'resolved' => 'Resuelto',
        'closed' => 'Cerrado',
    ] as $code => $name) {
        TicketStatus::create([
            'code' => $code,
            'name' => $name,
        ]);
    }
});

function workflowUser(string $role): User
{
    $user = User::factory()->create([
        'user_type' => $role === 'customer' ? 'external' : 'internal',
        'is_active' => true,
    ]);

    $user->assignRole($role);

    return $user;
}

function workflowTicket(
    string $status = 'open',
    ?User $requester = null,
    ?User $assignee = null,
    array $attributes = []
): Ticket {
    static $sequence = 0;

    $sequence++;

    $requester ??= workflowUser('customer');

    return Ticket::create(array_merge([
        'ticket_number' => sprintf('ZT-TEST-%06d', $sequence),
        'requester_id' => $requester->id,
        'assigned_to' => $assignee?->id,
        'department_id' => 1,
        'category_id' => 1,
        'priority_id' => 1,
        'status_id' => TicketStatus::where('code', $status)->firstOrFail()->id,
        'subject' => 'Ticket de prueba',
        'description' => 'Descripción de prueba',
    ], $attributes));
}

test('la primera asignación cambia open a in_progress, registra assigned_at y actividad', function () {
    $supervisor = workflowUser('supervisor');
    $agent = workflowUser('agent');
    $ticket = workflowTicket();

    $response = $this->actingAs($supervisor)
        ->patch(route('tickets.assign', $ticket), [
            'agent_id' => $agent->id,
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh()->load('status');

    expect($ticket->assigned_to)->toBe($agent->id)
        ->and($ticket->status->code)->toBe('in_progress')
        ->and($ticket->assigned_at)->not->toBeNull();

    $activity = $ticket->activities()->latest('id')->firstOrFail();

    expect($activity->action)->toBe('assigned')
        ->and($activity->user_id)->toBe($supervisor->id)
        ->and($activity->old_values)->toBe([
            'assigned_to' => null,
            'status' => 'open',
        ])
        ->and($activity->new_values)->toBe([
            'assigned_to' => $agent->id,
            'status' => 'in_progress',
        ]);
});

test('la reasignación mantiene assigned_at y registra reassigned', function () {
    $supervisor = workflowUser('supervisor');
    $firstAgent = workflowUser('agent');
    $secondAgent = workflowUser('agent');

    $assignedAt = now()->subHour()->startOfSecond();

    $ticket = workflowTicket('in_progress', assignee: $firstAgent, attributes: [
        'assigned_at' => $assignedAt,
    ]);

    $response = $this->actingAs($supervisor)
        ->patch(route('tickets.assign', $ticket), [
            'agent_id' => $secondAgent->id,
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh()->load('status');

    expect($ticket->assigned_to)->toBe($secondAgent->id)
        ->and($ticket->status->code)->toBe('in_progress')
        ->and($ticket->assigned_at->equalTo($assignedAt))->toBeTrue();

    $activity = $ticket->activities()->latest('id')->firstOrFail();

    expect($activity->action)->toBe('reassigned')
        ->and($activity->old_values)->toBe([
            'assigned_to' => $firstAgent->id,
            'status' => 'in_progress',
        ])
        ->and($activity->new_values)->toBe([
            'assigned_to' => $secondAgent->id,
            'status' => 'in_progress',
        ]);
});

test('assign rechaza tickets resolved y closed', function (string $status) {
    $ticket = workflowTicket($status);

    expect(fn () => app(TransitionTicketStatusAction::class)->execute($ticket, 'assign'))
        ->toThrow(DomainException::class);
})->with(['resolved', 'closed']);

test('el agente asignado puede resolver y se registra la actividad', function () {
    $agent = workflowUser('agent');
    $ticket = workflowTicket('in_progress', assignee: $agent, attributes: [
        'assigned_at' => now()->subHour(),
    ]);

    $response = $this->actingAs($agent)
        ->patch(route('tickets.resolve', $ticket));

    $response->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh()->load('status');

    expect($ticket->status->code)->toBe('resolved')
        ->and($ticket->resolved_at)->not->toBeNull();

    $activity = $ticket->activities()->latest('id')->firstOrFail();

    expect($activity->action)->toBe('resolved')
        ->and($activity->user_id)->toBe($agent->id)
        ->and($activity->old_values)->toBe(['status' => 'in_progress'])
        ->and($activity->new_values)->toBe(['status' => 'resolved']);
});

test('un agente no puede resolver un ticket asignado a otro agente', function () {
    $assignedAgent = workflowUser('agent');
    $otherAgent = workflowUser('agent');
    $ticket = workflowTicket('in_progress', assignee: $assignedAgent);

    $response = $this->actingAs($otherAgent)
        ->patch(route('tickets.resolve', $ticket));

    $response->assertForbidden();

    $ticket->refresh()->load('status');

    expect($ticket->status->code)->toBe('in_progress')
        ->and($ticket->resolved_at)->toBeNull()
        ->and($ticket->activities()->count())->toBe(0);
});

test('resolve rechaza estados distintos de in_progress', function (string $status) {
    $ticket = workflowTicket($status);

    expect(fn () => app(TransitionTicketStatusAction::class)->execute($ticket, 'resolve'))
        ->toThrow(DomainException::class);
})->with(['open', 'resolved', 'closed']);

test('supervisor puede reabrir un ticket resolved', function () {
    $supervisor = workflowUser('supervisor');
    $ticket = workflowTicket('resolved', attributes: [
        'resolved_at' => now()->subHour(),
    ]);

    $response = $this->actingAs($supervisor)
        ->patch(route('tickets.reopen', $ticket));

    $response->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh()->load('status');

    expect($ticket->status->code)->toBe('in_progress')
        ->and($ticket->resolved_at)->toBeNull();

    $activity = $ticket->activities()->latest('id')->firstOrFail();

    expect($activity->action)->toBe('reopened')
        ->and($activity->user_id)->toBe($supervisor->id)
        ->and($activity->old_values)->toBe(['status' => 'resolved'])
        ->and($activity->new_values)->toBe(['status' => 'in_progress']);
});

test('reopen rechaza un ticket closed', function () {
    $ticket = workflowTicket('closed', attributes: [
        'resolved_at' => now()->subHours(2),
        'closed_at' => now()->subHour(),
    ]);

    expect(fn () => app(TransitionTicketStatusAction::class)->execute($ticket, 'reopen'))
        ->toThrow(DomainException::class);
});

test('supervisor puede cerrar un ticket resolved', function () {
    $supervisor = workflowUser('supervisor');
    $resolvedAt = now()->subHour()->startOfSecond();

    $ticket = workflowTicket('resolved', attributes: [
        'resolved_at' => $resolvedAt,
    ]);

    $response = $this->actingAs($supervisor)
        ->patch(route('tickets.close', $ticket));

    $response->assertRedirect(route('tickets.show', $ticket));

    $ticket->refresh()->load('status');

    expect($ticket->status->code)->toBe('closed')
        ->and($ticket->closed_at)->not->toBeNull()
        ->and($ticket->resolved_at->equalTo($resolvedAt))->toBeTrue();

    $activity = $ticket->activities()->latest('id')->firstOrFail();

    expect($activity->action)->toBe('closed')
        ->and($activity->user_id)->toBe($supervisor->id)
        ->and($activity->old_values)->toBe(['status' => 'resolved'])
        ->and($activity->new_values)->toBe(['status' => 'closed']);
});

test('un agente no puede cerrar un ticket resolved', function () {
    $agent = workflowUser('agent');
    $ticket = workflowTicket('resolved', assignee: $agent, attributes: [
        'resolved_at' => now()->subHour(),
    ]);

    $response = $this->actingAs($agent)
        ->patch(route('tickets.close', $ticket));

    $response->assertForbidden();

    $ticket->refresh()->load('status');

    expect($ticket->status->code)->toBe('resolved')
        ->and($ticket->closed_at)->toBeNull()
        ->and($ticket->activities()->count())->toBe(0);
});

test('close rechaza un ticket in_progress', function () {
    $ticket = workflowTicket('in_progress');

    expect(fn () => app(TransitionTicketStatusAction::class)->execute($ticket, 'close'))
        ->toThrow(DomainException::class);
});
