<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PlainUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => bcrypt('password'),
            'mobile'=> '+201022893367',
            'mobile_verified_at'=> now(),
            'email_verified_at' => now(),
            'is_active' => true
        ]);
    }
}
