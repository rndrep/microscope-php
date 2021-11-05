<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('rock_types')->insert(['name' => $name]);
        }
    }

    private $names = [
        'магматический',
        'метаморфический',
        'осадочный',
    ];
}
