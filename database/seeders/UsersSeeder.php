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
                'name' => 'Admin Test',
                'username' => 'admin2021',
                'user_added' => 'admin2021',
                'email' => 'test@email.com',
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
