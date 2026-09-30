<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(CsvReader $csvReader): void
    {
        $rows = $csvReader->read(
            database_path('seeders/data/departments.csv'),
            ['code', 'name', 'description', 'is_active']
        );

        foreach ($rows as $data) {
            Department::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'is_active' => (bool) $data['is_active'],
                ]
            );
        }
    }
}
