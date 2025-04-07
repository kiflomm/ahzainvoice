<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ahazinvoice.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // You should change this password in production
            'role' => 'super_admin',
            'is_verified' => true,
        ]);
    }
}
