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
            'login' => 'super-admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'admin',
            'role_id' => User::ROLE_ADMIN,
        ]);
        DB::table('users')->insert([
            'login' => 'manager',
            'email' => 'mng@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'manager',
            'role_id' => User::ROLE_MANAGER,
        ]);
        DB::table('users')->insert([
            'login' => 'content-manager',
            'email' => 'cm@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'content manager',
            'role_id' => User::ROLE_CONTENT,
        ]);
        DB::table('users')->insert([
            'login' => 'user',
            'email' => 'user@test.com',
            'password' => Hash::make('123'),
            'first_name' => 'user',
            'role_id' => User::ROLE_USER,
        ]);
    }
}
