<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PrioritySeeder::class,
            TicketStatusSeeder::class,
            DepartmentSeeder::class,
            CategorySeeder::class,
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
