<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFossilCoords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fossils', function (Blueprint $table) {
            $table->float('x')->nullable();
            $table->float('y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fossils', function (Blueprint $table) {
            $table->dropColumn('x');
            $table->dropColumn('y');
        });
    }
}
