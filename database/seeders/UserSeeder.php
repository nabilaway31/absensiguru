<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */  
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GURU
        |--------------------------------------------------------------------------
        */
        $guruUser = User::create([
            'name' => 'Danang Teguh Santoso',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $guruUser->id,
            'nip' => '1987654321',
            'nama' => 'Danang Teguh Santoso',
            'jenis_kelamin' => 'L',
            'alamat' => 'Mojokerto',
            'no_hp' => '08123456789',
        ]);
    }
}
