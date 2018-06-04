<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_type', 3);
            $table->string('fio', 150);
            $table->string('company', 150)->nullable();
            $table->string('inn', 12)->nullable();
            $table->string('kpp', 12)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('country', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('building', 20)->nullable();
            $table->string('flat', 10)->nullable();
            $table->string('password', 100);
            $table->rememberToken();
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
