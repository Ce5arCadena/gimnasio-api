<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleSuperAdmin = Role::where('name', 'SUPER_ADMIN')->firstOrFail();

        User::firstOrCreate([
            'email' => 'superadmin@admin.com'
        ], [
            'name' => 'SUPER ADMIN',
            'email' => 'superadmin@admin.com',
            'password' => config('gym.super_admin_password'),
            'role_id' => $roleSuperAdmin->id,
            'gym_id' => null
        ]);
    }
}
