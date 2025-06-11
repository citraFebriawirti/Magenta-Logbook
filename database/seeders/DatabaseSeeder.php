<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mentor Utama',
            'username' => 'mentor',
            'password' => bcrypt('12345678'),
            'role' => 'mentor',
        ]);
        User::create([
            'name' => 'Citra',
            'username' => 'peserta',
            'password' => bcrypt('12345678'),
            'role' => 'peserta',
        ]);
    }
}