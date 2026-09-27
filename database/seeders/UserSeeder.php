<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
           User::create([
        'name' => 'Admin User',
        'email' => 'admin@tanapa.go.tz',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);

    User::create([
        'name' => 'Officer User',
        'email' => 'officer@tanapa.go.tz',
        'password' => bcrypt('password'),
        'role' => 'officer'
    ]);

    User::create([
        'name' => 'Accountant User',
        'email' => 'accountant@tanapa.go.tz',
        'password' => bcrypt('password'),
        'role' => 'accountant'
    ]);
    }
}
