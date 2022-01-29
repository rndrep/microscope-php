<?php

use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\MineralSyngony;
use Illuminate\Database\Migrations\Migration;


class ToLowerDictNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $models = [IndexFossil::class, Invertebrate::class, MineralSyngony::class,

        ];
        foreach ($models as $model) {
            foreach ($model::all() as $item) {
                $item->name = mb_strtolower($item->name);
                $item->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
