<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(CsvReader $csvReader): void
    {
        $rows = $csvReader->read(
            database_path('seeders/data/categories.csv')
        );

        foreach ($rows as $data) {
            $department = Department::where('code', $data['department_code'])->firstOrFail();
            Category::updateOrCreate(
                [
                    'department_id' => $department->id,
                    'code' => $data['code'],
                ],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'is_active' => (bool) $data['is_active'],
                ]
            );
        }
    }
}
