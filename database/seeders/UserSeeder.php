<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'User LMW',
            'username' => 'user1',
            'email' => 'user@lmwstore.com',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole('user');

        $admin = User::factory()->create([
            'name' => 'Admin LMW',
            'username' => 'admin',
            'email' => 'admin@lmwstore.com',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('admin');
    }
}
