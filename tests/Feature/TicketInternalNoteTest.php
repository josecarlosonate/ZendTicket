<?php

use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
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

    TicketStatus::create([
        'code' => 'in_progress',
        'name' => 'En progreso',
    ]);
});

function internalNoteUser(string $role): User
{
    $user = User::factory()->create([
        'user_type' => $role === 'customer' ? 'external' : 'internal',
        'is_active' => true,
    ]);

    $user->assignRole($role);

    return $user;
}

function internalNoteTicket(?User $requester = null, ?User $assignee = null): Ticket
{
    static $sequence = 0;

    $sequence++;

    $requester ??= internalNoteUser('customer');

    return Ticket::create([
        'ticket_number' => sprintf('ZT-NOTE-%06d', $sequence),
        'requester_id' => $requester->id,
        'assigned_to' => $assignee?->id,
        'department_id' => 1,
        'category_id' => 1,
        'priority_id' => 1,
        'status_id' => TicketStatus::where('code', 'in_progress')->firstOrFail()->id,
        'subject' => 'Ticket para notas internas',
        'description' => 'Descripción de prueba',
    ]);
}

test('el agente asignado puede crear una nota interna', function () {
    $agent = internalNoteUser('agent');
    $ticket = internalNoteTicket(assignee: $agent);

    $response = $this->actingAs($agent)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Nota creada por el agente asignado.',
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $agent->id,
        'body' => 'Nota creada por el agente asignado.',
        'is_internal' => true,
    ]);
});

test('un agente no asignado no puede crear una nota interna', function () {
    $assignedAgent = internalNoteUser('agent');
    $otherAgent = internalNoteUser('agent');
    $ticket = internalNoteTicket(assignee: $assignedAgent);

    $response = $this->actingAs($otherAgent)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Intento no autorizado.',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $otherAgent->id,
    ]);
});

test('el supervisor puede crear una nota interna', function () {
    $supervisor = internalNoteUser('supervisor');
    $ticket = internalNoteTicket();

    $response = $this->actingAs($supervisor)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Nota del supervisor.',
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $supervisor->id,
        'body' => 'Nota del supervisor.',
        'is_internal' => true,
    ]);
});

test('el administrador puede crear una nota interna', function () {
    $admin = internalNoteUser('admin');
    $ticket = internalNoteTicket();

    $response = $this->actingAs($admin)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Nota del administrador.',
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $admin->id,
        'body' => 'Nota del administrador.',
        'is_internal' => true,
    ]);
});

test('el cliente no ve las notas internas en el ticket', function () {
    $customer = internalNoteUser('customer');
    $admin = internalNoteUser('admin');
    $ticket = internalNoteTicket(requester: $customer);

    $ticket->comments()->create([
        'user_id' => $admin->id,
        'body' => 'Información reservada para soporte.',
        'is_internal' => true,
    ]);

    $response = $this->actingAs($customer)
        ->get(route('tickets.show', $ticket));

    $response->assertOk()
        ->assertDontSee('Notas internas')
        ->assertDontSee('Información reservada para soporte.');
});

test('el cliente no puede crear una nota interna mediante un post directo', function () {
    $customer = internalNoteUser('customer');
    $ticket = internalNoteTicket(requester: $customer);

    $response = $this->actingAs($customer)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Intento del cliente.',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseMissing('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $customer->id,
    ]);
});

test('el servidor fuerza todas las notas creadas como internas', function () {
    $admin = internalNoteUser('admin');
    $ticket = internalNoteTicket();

    $response = $this->actingAs($admin)
        ->post(route('tickets.comments.store', $ticket), [
            'body' => 'Debe permanecer interna.',
            'is_internal' => false,
        ]);

    $response->assertRedirect(route('tickets.show', $ticket));

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $admin->id,
        'body' => 'Debe permanecer interna.',
        'is_internal' => true,
    ]);
});

test('un usuario no autenticado no puede crear una nota interna', function () {
    $ticket = internalNoteTicket();

    $response = $this->post(route('tickets.comments.store', $ticket), [
        'body' => 'Intento sin autenticación.',
    ]);

    $response->assertRedirect(route('login'));

    expect($ticket->comments()->count())->toBe(0);
});
