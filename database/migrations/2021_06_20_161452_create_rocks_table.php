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
            $table->string('description')->nullable();
            $table->point('coords')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('forming_mineral_id')->nullable()->constrained('minerals');
            $table->foreignId('accessory_mineral_id')->nullable()->constrained('minerals');
            $table->foreignId('rock_type_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('period_id')->nullable();
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
