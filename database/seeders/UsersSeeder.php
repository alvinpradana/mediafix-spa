<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Test',
                'username' => 'test123',
                'user_added' => 'test123',
                'email' => 'test@email.com',
                'password' => 'password',
                'phone' => '081234567890',
                'workshop' => 'Yogyakarta',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin',
                'username' => 'admin2021',
                'user_added' => 'admin2021',
                'email' => 'admin@email.com',
                'password' => 'password',
                'phone' => '081328944121',
                'workshop' => 'Yogyakarta',
                'email_verified_at' => now(),
            ]
        ])->each(function ($user) {
            User::create($user);
        });
    }
}
