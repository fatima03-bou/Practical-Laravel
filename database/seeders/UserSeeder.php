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
        //
        User::create([
            'name' => 'Admin',
            'email' => 'yassine22real@gmail.com',
            'password' => Hash::make('aaaaaaaa'),
            'role' => 'admin',
            'balance' => 5000,
            'country' => 'Morocco',
        ]);
        User::create([
            'name' => 'Super Admin',
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make('aaaaaaaa'),
            'role' => 'super_admin',
            "country" => "France",  
        ]);
        User::factory(3)->create();
    }
}
