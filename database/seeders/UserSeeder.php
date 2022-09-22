<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'is_admin' => 1,
            'password' => bcrypt('123@admin')
        ]);

        User::create([
            'name' => 'Author',
            'email' => 'author@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);


    }
}
