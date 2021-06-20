<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->point('coords');
            $table->string('photo');
            $table->foreignId('forming_mineral_id')->constrained('minerals');
            $table->foreignId('accessory_mineral_id')->constrained('minerals');
            $table->foreignId('rock_type_id');
            $table->foreignId('category_id');
            $table->foreignId('period_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rocks');
    }
}
