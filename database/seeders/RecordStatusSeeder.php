<?php

namespace Database\Seeders;

use App\Models\RecordStatus;
use Illuminate\Database\Seeder;

class RecordStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'status' => 'Active', 'description' => 'Active status'],
            ['id' => 2, 'status' => 'Inactive', 'description' => 'Inactive status'],
            ['id' => 3, 'status' => 'Deleted', 'description' => 'Deleted status'],
            ['id' => 4, 'status' => 'Pending', 'description' => 'Pending status'],
            ['id' => 5, 'status' => 'Pending Review', 'description' => 'Pending review status']
        ];

        foreach ($statuses as $status) {
            RecordStatus::query()->firstOrCreate($status, $status);
        }
    }
}
