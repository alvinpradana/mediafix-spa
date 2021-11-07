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
                'name' => 'Alvin Novian',
                'username' => 'alvin123',
                'email' => 'alvin@admin.com',
                'password' => bcrypt('admin123'),
                'phone' => '081328944121',
                'workshop' => 'Yogyakarta',
                'email_verified_at' => now(),
            ]
        ])->each(function ($user) {
            User::create($user);
        });
    }
}
