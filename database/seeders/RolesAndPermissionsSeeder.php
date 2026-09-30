<?php

namespace Database\Seeders;

use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

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
            'tickets.change_status',

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
                'tickets.create',
                'tickets.view_assigned',
                'tickets.update',
                'tickets.change_status',
                'comments.create',
                'comments.create_internal',
                'attachments.create',
            ],

            'supervisor' => [
                'tickets.create',
                'tickets.view_assigned',
                'tickets.view_all',
                'tickets.update',
                'tickets.assign',
                'tickets.change_status',
                'comments.create',
                'comments.create_internal',
                'attachments.create',
                'reports.view',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions(Permission::all());

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::findOrCreate($roleName);
            $role->syncPermissions($rolePermissions);
        }
    }
}
