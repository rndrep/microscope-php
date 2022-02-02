<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnlimitedTextFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rocks', function (Blueprint $table) {
            $table->text('extra')->nullable()->change();

        });
        Schema::table('minerals', function (Blueprint $table) {
            $table->text('composition')->nullable()->change();
            $table->text('aggregates')->nullable()->change();
            $table->text('feature')->nullable()->change();
            $table->text('color')->nullable()->change();
            $table->text('feature_color')->nullable()->change();
            $table->text('transparency')->nullable()->change();
            $table->text('diagnosis')->nullable()->change();
            $table->text('genesis')->nullable()->change();
            $table->text('paragenesis')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rocks', function (Blueprint $table) {
            $table->string('extra')->nullable()->change();

        });
        Schema::table('minerals', function (Blueprint $table) {
            $table->string('composition')->nullable()->change();
            $table->string('aggregates')->nullable()->change();
            $table->string('feature')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->string('feature_color')->nullable()->change();
            $table->string('transparency')->nullable()->change();
            $table->string('diagnosis')->nullable()->change();
            $table->string('genesis')->nullable()->change();
            $table->string('paragenesis')->nullable()->change();
        });
    }
}
