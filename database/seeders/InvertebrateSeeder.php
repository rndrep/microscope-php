<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvertebrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('invertebrates')->insert(['name' => $name]);
        }
    }

    private $names = [
        'Археоциаты',
        'Саркодовые',
        'Губки',
        'Книдарии',
        'Брахиоподы',
        'Черви',
        'Иглокожие',
        'Членистоногии',
        'Моллюски',
    ];
}
