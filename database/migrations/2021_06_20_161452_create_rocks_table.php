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
            $table->text('description')->nullable();
//            $table->point('coords')->nullable(); // не создаётся
            $table->float('x')->nullable();
            $table->float('y')->nullable();
            $table->string('photo')->nullable();
            $table->integer('is_public')->nullable();
            $table->string('video')->nullable();
            $table->string('model_3d')->nullable();
            $table->string('region')->nullable();
            $table->string('extra')->nullable();
            $table->foreignId('rock_type_id')->nullable();
            $table->foreignId('rock_class_id')->nullable();
            $table->foreignId('rock_squad_id')->nullable();
            $table->foreignId('rock_family_id')->nullable();
            $table->foreignId('rock_kind_id')->nullable();
            $table->foreignId('rock_texture_id')->nullable();
            $table->foreignId('rock_structure_id')->nullable();
            $table->foreignId('fossil_id')->nullable();
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
