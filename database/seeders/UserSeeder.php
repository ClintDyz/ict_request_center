<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'emp_id' => 'EMP001',
            'firstname' => 'Admin',
            'middlename' => '',
            'lastname' => 'User',
            'gender' => 'Male',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'roles' => 'Admin',
            'is_active' => true,
        ]);
    }
}
