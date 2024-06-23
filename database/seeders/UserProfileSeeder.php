<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            ['id' => 1, 'user_id' => 1, 'dob' => Carbon::now()->subYears(30)->format('Y-m-d'), 'idNumber' => Str::random(), 'profession' => 'Software Developer', 'highestEductionQualification' => 'Degree', 'bio' => 'Experienced Java and React developer', 'maritalStatus' => 'Married', 'gender' => 'Male', 'religion' => 'Christianity', 'address' => 'Harare'],
            ['id' => 2, 'user_id' => 2, 'dob' => Carbon::now()->subYears(30)->format('Y-m-d'), 'idNumber' => Str::random(), 'profession' => 'Software Developer', 'highestEductionQualification' => 'Degree', 'bio' => 'Experienced Java and PHP backend developer', 'maritalStatus' => 'Married', 'gender' => 'Male', 'religion' => 'Christianity', 'address' => 'Harare']
        ];

        foreach ($profiles as $profile) {
            UserProfile::query()->firstOrCreate($profile, $profile);
        }
    }
}
