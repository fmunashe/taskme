<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RecordStatusSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(UserProfileSeeder::class);
        $this->call(WorkExperienceSeeder::class);
        $this->call(WorkDutySeeder::class);
    }
}
