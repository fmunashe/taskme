<?php

namespace Database\Seeders;

use App\Models\WorkDuty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkDutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $duties = [
            ['id' => 1, 'work_experience_id' => 1, 'dutyDescription' => Str::random()],
            ['id' => 2, 'work_experience_id' => 1, 'dutyDescription' => Str::random()],
            ['id' => 3, 'work_experience_id' => 1, 'dutyDescription' => Str::random()],
            ['id' => 4, 'work_experience_id' => 1, 'dutyDescription' => Str::random()],
            ['id' => 5, 'work_experience_id' => 1, 'dutyDescription' => Str::random()],
            ['id' => 6, 'work_experience_id' => 2, 'dutyDescription' => Str::random()],
            ['id' => 7, 'work_experience_id' => 2, 'dutyDescription' => Str::random()],
            ['id' => 8, 'work_experience_id' => 2, 'dutyDescription' => Str::random()],
            ['id' => 9, 'work_experience_id' => 2, 'dutyDescription' => Str::random()],
            ['id' => 10, 'work_experience_id' => 2, 'dutyDescription' => Str::random()],
        ];
        foreach ($duties as $duty) {
            WorkDuty::query()->firstOrCreate($duty);
        }
    }
}
