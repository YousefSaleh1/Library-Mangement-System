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
        User::create([
            'name'     => 'Owner',
            'email'    => 'yousefsaleh.888.it@gmail.com',
            'password' => 'owner1234',
            'isAdmin'  => true
        ]);
    }
}
