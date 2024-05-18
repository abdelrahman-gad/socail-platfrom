<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'mobile'=> '955345',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);
    }
}
