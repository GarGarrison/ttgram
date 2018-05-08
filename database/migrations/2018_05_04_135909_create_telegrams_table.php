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
            $table->integer('uid')->nullable();
            $table->string('s_type');
            $table->string('notification');
            $table->string('s_fio', 150);
            $table->string('s_company', 150)->nullable();
            $table->string('s_phone', 20);
            $table->string('s_email', 100);
            $table->string('s_region', 100)->nullable();
            $table->string('s_city', 100)->nullable();
            $table->string('s_street', 100)->nullable();
            $table->string('s_building', 20)->nullable();
            $table->string('s_flat', 10)->nullable();
            $table->string('r_name', 150);
            $table->string('r_surname', 150);
            $table->string('r_company', 150)->nullable();
            $table->string('r_phone', 20)->nullable();
            $table->string('r_email', 100)->nullable();
            $table->string('r_region', 100);
            $table->string('r_city', 100);
            $table->string('r_street', 100);
            $table->string('r_building', 20);
            $table->string('r_flat', 10)->nullable();
            $table->string('service_type');
            $table->text('text')->nullable();
            $table->date('copy_date')->nullable();
            $table->string('copy_number')->nullable();
            $table->string('copy_direction')->nullable();
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
        Schema::dropIfExists('telegrams');
    }
}
