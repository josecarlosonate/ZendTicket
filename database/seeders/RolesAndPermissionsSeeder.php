<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'tickets.create',
            'tickets.view_own',
            'tickets.view_assigned',
            'tickets.view_all',
            'tickets.update',
            'tickets.assign',
            'tickets.resolve',
            'tickets.reopen',
            'tickets.change_priority',
            'tickets.close',

            'comments.create',
            'comments.create_internal',

            'attachments.create',

            'catalogs.manage',
            'users.manage',
            'roles.manage',
            'reports.view',
        ];

        $roles = [
            'customer' => [
                'tickets.create',
                'tickets.view_own',
                'comments.create',
                'attachments.create',
            ],

            'agent' => [
                'tickets.view_assigned',
                'tickets.update',
                'tickets.resolve',
                'comments.create',
                'comments.create_internal',
                'attachments.create',
            ],

            'supervisor' => [
                'tickets.view_assigned',
                'tickets.view_all',
                'tickets.update',
                'tickets.assign',
                'tickets.resolve',
                'tickets.reopen',
                'tickets.change_priority',
                'tickets.close',
                'comments.create',
                'comments.create_internal',
                'attachments.create',
                'reports.view',
            ],

            'admin' => [
                'tickets.view_all',
                'tickets.update',
                'tickets.assign',
                'tickets.resolve',
                'tickets.reopen',
                'tickets.change_priority',
                'tickets.close',
                'catalogs.manage',
                'users.manage',
                'roles.manage',
                'reports.view',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName);
            $role->syncPermissions($rolePermissions);
        }
    }
}
