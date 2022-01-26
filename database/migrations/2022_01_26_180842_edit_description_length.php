<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDescriptionLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('minerals', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('varieties')->nullable()->change();
            $table->text('other_props')->nullable()->change();
        });
        Schema::table('fossils', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
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
            $table->string('description')->nullable()->change();
            $table->string('varieties')->nullable()->change();
            $table->string('other_props')->nullable()->change();
        });
        Schema::table('fossils', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });
    }
}
