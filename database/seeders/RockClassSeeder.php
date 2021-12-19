<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('rock_classes')->insert(['name' => $name]);
        }
    }

    private $names = [
        'вулканический',
        'гипабиссальный',
        'контактовый',
        'региональный',
        'динамометаморфический',
        'псаммитолиты (песчаные)',
        'пелитолиты (глинистые)',
        'алюминиевый',
        'карбонатный',
        'плутонический',
        'ультраметаморфический (инъекционный)',
        'метасоматический',
    ];
}
