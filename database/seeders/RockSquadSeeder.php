<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockSquadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'ультраосновной', 'description' => ''],
            ['name' => 'основной', 'description' => ''],
            ['name' => 'средний', 'description' => ''],
            ['name' => 'кислый', 'description' => ''],
        ];
        foreach ($items as $item) {
            DB::table('rock_squads')->insert($item);
        }
    }
}
