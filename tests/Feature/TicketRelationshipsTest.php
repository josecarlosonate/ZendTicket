<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un usuario puede pertenecer a varios departamentos', function () {
    // Preparar los registros.
    $user = User::factory()->create([
        'user_type' => 'internal',
    ]);

    $support = Department::create([
        'code' => 'technical_support',
        'name' => 'Soporte técnico',
    ]);

    $billing = Department::create([
        'code' => 'billing',
        'name' => 'Facturación',
    ]);

    // Asociar el usuario a ambos departamentos.
    $user->departments()->attach([
        $support->id,
        $billing->id,
    ]);

    // Comprobar los departamentos del usuario.
    expect($user->departments)->toHaveCount(2);
    expect($user->departments->modelKeys())
        ->toContain($support->id, $billing->id);

    // Comprobar la relación inversa.
    expect($support->users)->toHaveCount(1);
    expect($support->users->first()->is($user))->toBeTrue();

    expect($billing->users)->toHaveCount(1);
    expect($billing->users->first()->is($user))->toBeTrue();
});
