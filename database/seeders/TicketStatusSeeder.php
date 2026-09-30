<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    public function run(CsvReader $csvReader): void
    {
        $rows = $csvReader->read(
            database_path('seeders/data/ticket_statuses.csv')
        );

        foreach ($rows as $data) {
            TicketStatus::updateOrCreate(
                ['code' => $data['code']],
                ['name' => $data['name']]
            );
        }
    }
}
