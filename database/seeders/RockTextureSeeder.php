<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RockTextureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('rock_textures')->insert(['name' => $name]);
        }
    }

    private $names = [
        'массивная ',
        'пятнистая',
        'гнейсовидная',
        'слоистая',
        'детритовая',
    ];
}
