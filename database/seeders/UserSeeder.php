<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'login' => 'adm',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'admin',
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
            'login' => 'user',
            'email' => 'user@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'user',
            'role_id' => 2,
        ]);
    }
}
