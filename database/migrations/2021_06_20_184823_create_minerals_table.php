<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMineralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minerals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('composition')->nullable();
            $table->string('class')->nullable();
            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            $table->string('varieties')->nullable();
            $table->string('aggregates')->nullable();
            $table->string('feature')->nullable();
            $table->string('syngony')->nullable();
            $table->string('crystal_form')->nullable();
            $table->smallInteger('hardness')->nullable();
            $table->float('specific_gravity')->nullable();
            $table->string('color')->nullable();
            $table->string('feature_color')->nullable();
            $table->string('shine')->nullable();
            $table->string('transparency')->nullable();
            $table->string('other_props')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('genesis')->nullable();
            $table->string('paragenesis')->nullable();
            $table->float('x')->nullable();
            $table->float('y')->nullable();
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
        Schema::dropIfExists('minerals');
    }
}
