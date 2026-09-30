<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = config('zendticket.admin.name');
        $email = config('zendticket.admin.email');
        $password = config('zendticket.admin.password');

        if (! $name || ! $email || ! $password) {
            throw new RuntimeException('ZendTicket admin credentials are not configured.');
        }

        $admin = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );
        $admin->syncRoles(['admin']);
    }
}
