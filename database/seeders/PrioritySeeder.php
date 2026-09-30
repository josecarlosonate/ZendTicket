<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(CsvReader $csvReader): void
    {
        $rows = $csvReader->read(
            database_path('seeders/data/priorities.csv')
        );

        foreach ($rows as $data) {
            Priority::updateOrCreate(
                ['name' => $data['name']],
                [
                    'level' => (int) $data['level'],
                    'is_active' => (bool) $data['is_active'],
                ]
            );
        }
    }
}
