<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->integer('auth')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('patronymic')->nullable(); //отчество
            $table->integer('role_id')->default(0);
            $table->smallInteger('is_sso')->default(0);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
