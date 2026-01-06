<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'user1@test.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'user2@test.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
