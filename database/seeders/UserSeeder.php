<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->insert([
            [
                'username'     => 'admin',
                'password'     => Hash::make('password123'),
                'email'        => 'admin@example.com',
                'nama_lengkap' => 'Administrator',
                'isDeleted'    => 0,
                'created_by'   => 'Seeder',
                'created_at'   => now(),
            ],
            [
                'username'     => 'user1',
                'password'     => Hash::make('password123'),
                'email'        => 'user1@example.com',
                'nama_lengkap' => 'User Satu',
                'isDeleted'    => 0,
                'created_by'   => 'Seeder',
                'created_at'   => now(),
            ],
            [
                'username'     => 'user2',
                'password'     => Hash::make('password123'),
                'email'        => 'user2@example.com',
                'nama_lengkap' => 'User Dua',
                'isDeleted'    => 0,
                'created_by'   => 'Seeder',
                'created_at'   => now(),
            ],
        ]);
    }
}
