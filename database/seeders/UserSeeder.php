<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
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
         User::firstOrCreate([
            'email' => 'testUserOne@gmail.com',
        ], [
                'name' => 'User One',
                'email' => 'testUserOne@gmail.com',
                'password' => Hash::make('testuser123'),
            ]
        );
         User::firstOrCreate([
            'email' => 'testUserTwo@gmail.com',
        ], [
                'name' => 'User Two',
                'email' => 'testUserTwo@gmail.com',
                'password' => Hash::make('testuser123'),
            ]
        );
         User::firstOrCreate([
            'email' => 'testUserThree@gmail.com',
        ], [
                'name' => 'User Three',
                'email' => 'testUserthree@gmail.com',
                'password' => Hash::make('testuser123'),
            ]
        );
    }
}
