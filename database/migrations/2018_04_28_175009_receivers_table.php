<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('template_name');
            $table->string('name', 150)->nullable();
            $table->string('surname', 150)->nullable();
            $table->string('company', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('building', 20)->nullable();
            $table->string('flat', 10)->nullable();
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
        Schema::dropIfExists('receivers');
    }
}
