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
                'is_admin' => null,
                'name' => 'Test',
                'username' => 'test123',
                'user_added' => 'admin2021',
                'email' => 'test@email.com',
                'password' => 'password',
                'phone' => '81234567890',
                'workshop' => 'Yogyakarta',
                'image' => null,
                'email_verified_at' => now(),
            ],
            [
                'is_admin' => 1,
                'name' => 'Admin',
                'username' => 'admin2021',
                'user_added' => 'admin2021',
                'email' => 'admin@email.com',
                'password' => 'password',
                'phone' => '81328944121',
                'workshop' => 'Yogyakarta',
                'image' => null,
                'email_verified_at' => now(),
            ]
        ])->each(function ($user) {
            User::create($user);
        });
    }
}
