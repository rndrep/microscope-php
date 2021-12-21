<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RockClassSeeder::class,
            RockFamilySeeder::class,
            RockKindSeeder::class,
            RockSquadSeeder::class,
            RockStructureSeeder::class,
            RockTextureSeeder::class,
            RockTypeSeeder::class,
            InvertebrateSeeder::class,
            IndexFossilSeeder::class,
            MineralSyngonySeeder::class,
            MineralSplittingSeeder::class,
            RockClass2KindSeeder::class
        ]);
    }
}
