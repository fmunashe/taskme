<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 1, 'firstName' => 'Ephraim', 'lastName' => 'Madondo','email'=>'ephraim@gmail.com', 'phoneNumber' => '0778680455', 'password' => Hash::make('password'), 'otp' => mt_rand(100000, 999999), 'email_verified_at' => now(), 'mobile_verified_at' => now(), 'role_id' => 3],
            ['id' => 2, 'firstName' => 'Farai', 'lastName' => 'Zihove','email'=>'zihovem@gmail.com', 'phoneNumber' => '0778234258', 'password' => Hash::make('password'), 'otp' => mt_rand(100000, 999999), 'email_verified_at' => now(), 'mobile_verified_at' => now(), 'role_id' => 3],
        ];

        foreach ($users as $user) {
            User::query()->firstOrCreate($user, $user);
        }
    }
}
