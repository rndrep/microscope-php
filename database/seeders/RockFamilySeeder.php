<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'обломочные', 'description' => ''],
            ['name' => 'хемогенные', 'description' => ''],
            ['name' => 'органогенные ', 'description' => ''],
        ];
        foreach ($items as $item) {
            DB::table('rock_families')->insert($item);
        }
    }
}
