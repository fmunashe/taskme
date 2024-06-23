<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'User', 'description' => 'User Role'],
            ['id' => 2, 'name' => 'Admin', 'description' => 'Administrator Role'],
            ['id' => 3, 'name' => 'SuperAdmin', 'description' => 'Administrator Role'],
            ['id' => 4, 'name' => 'Client', 'description' => 'Client Role'],
            ['id' => 5, 'name' => 'ServiceProvider', 'description' => 'Service Provider Role'],
            ['id' => 6, 'name' => 'Support', 'description' => 'Support Role'],
        ];

        foreach ($roles as $role) {
            Role::query()->firstOrCreate($role, $role);
        }
    }
}
