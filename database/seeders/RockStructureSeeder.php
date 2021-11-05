<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('rock_structures')->insert(['name' => $name]);
        }
    }

    private $names = [
        'крупнозернистая',
        'микрокристаллическая',
        'порфировидная',
        'микрогранолепидобластовая',
        'гранолепидобластовая',
        'псаммитовая',
        'пелитовая',
        'порфиробластовая',
        'порфировая',
        'гранитовая',
    ];
}
