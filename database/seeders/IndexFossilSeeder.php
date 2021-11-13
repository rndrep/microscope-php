<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndexFossilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->names as $name) {
            DB::table('index_fossils')->insert(['name' => $name]);
        }
    }

    private $names = [
        'Неоген',
        'Палеоген',
        'Мел',
        'Юра',
        'Триас',
        'Пермь',
        'Карбон',
        'Девон',
        'Силур',
        'Ордовик',
        'Кембрий',
    ];
}
