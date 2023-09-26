<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Studio Onze',
            'email' => 'admin@studioonze.com.br',
            'password' => Hash::make('StudioOnze@123'),
        ]);
    }
}
