<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'username' => 'admin',
            'password' => Hash::make(12345678),
            'email' => 'admin@gmail.com',
            'first_name' => 'admin',
            'is_superuser' => true,
            'role' => 'ADS',
            'phone_number' => 9998887778,
            'dob' => '2000-01-01'
        ]);
    }
}
