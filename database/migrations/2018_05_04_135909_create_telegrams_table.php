<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegrams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('s_type')->nullable();
            $table->string('notification')->nullable();
            $table->string('s_fio', 150)->nullable();
            $table->string('s_company', 150)->nullable();
            $table->string('s_phone', 20)->nullable();
            $table->string('s_email', 100)->nullable();
            $table->string('s_region', 100)->nullable();
            $table->string('s_city', 100)->nullable();
            $table->string('s_street', 100)->nullable();
            $table->string('s_building', 20)->nullable();
            $table->string('s_flat', 10)->nullable();
            $table->string('r_name', 150)->nullable();
            $table->string('r_surname', 150)->nullable();
            $table->string('r_company', 150)->nullable();
            $table->string('r_phone', 20)->nullable();
            $table->string('r_email', 100)->nullable();
            $table->string('r_region', 100)->nullable();
            $table->string('r_city', 100)->nullable();
            $table->string('r_street', 100)->nullable();
            $table->string('r_building', 20)->nullable();
            $table->string('r_flat', 10)->nullable();
            $table->string('service_type')->nullable();
            $table->text('text')->nullable();
            $table->date('copy_date')->nullable();
            $table->string('copy_number')->nullable();
            $table->string('copy_direction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegrams');
    }
}
