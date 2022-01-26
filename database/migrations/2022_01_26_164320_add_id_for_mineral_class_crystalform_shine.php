<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdForMineralClassCrystalformShine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('minerals', function (Blueprint $table) {
            $table->foreignId('mineral_class_id')->nullable();
            $table->foreignId('mineral_crystal_form_id')->nullable();
            $table->foreignId('mineral_shine_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('minerals', function (Blueprint $table) {
            $table->dropColumn('mineral_class_id');
            $table->dropColumn('mineral_crystal_form_id');
            $table->dropColumn('mineral_shine_id');
        });
    }
}
