<?php

namespace Database\Seeders;

use App\Models\WorkExperience;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            ['id' => 1, 'user_profile_id' => 1, 'positionHeld' => 'Software Engineer', 'startDate' => Carbon::now()->subYears(7)->format('Y-m-d'), 'endDate' => Carbon::now()->subYears(4)->format('Y-m-d'), 'reasonForLeaving' => 'Career Growth', 'organisation' => Str::random()],
            ['id' => 2, 'user_profile_id' => 2, 'positionHeld' => 'Software Engineer', 'startDate' => Carbon::now()->subYears(7)->format('Y-m-d'), 'endDate' => Carbon::now()->subYears(4)->format('Y-m-d'), 'reasonForLeaving' => 'Career Growth', 'organisation' => Str::random()]
        ];

        foreach ($experiences as $experience) {
            WorkExperience::query()->firstOrCreate($experience, $experience);
        }
    }
}
