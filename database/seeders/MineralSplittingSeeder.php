<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MineralSplittingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('mineral_splittings')->insert(['name' => $name]);
        }
    }

    private $names = [
        'весьма совершенная',
        'совершенная',
        'средняя',
        'несовершенная',
        'весьма несовершенная',
    ];
}
