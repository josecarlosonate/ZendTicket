<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(CsvReader $csvReader): void
    {
        $rows = $csvReader->read(
            database_path('seeders/data/users.csv'),
            ['name', 'email', 'user_type', 'role']
        );

        foreach ($rows as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'user_type' => $data['user_type'],
                    'is_active' => true,
                ]
            );

            $user->syncRoles($data['role']);
        }
    }
}
