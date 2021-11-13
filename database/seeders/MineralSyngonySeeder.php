<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MineralSyngonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('mineral_syngonies')->insert(['name' => $name]);
        }
    }

    private $names = [
        'Триклинная',
        'Моноклинная',
        'Ромбическая',
        'Тетрагональная',
        'Гексагональная',
        'Кубическая',
    ];
}
