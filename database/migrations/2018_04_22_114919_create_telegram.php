<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // r_ - reciever data
        // s_ - sender data
        Schema::create('telegram', function (Blueprint $table) {
            $table->increments('id');
            $table->string('s_type'); // fiz/jur
            $table->string('s_fio', 150);
            $table->string('r_name', 150);
            $table->string('r_surname', 150);
            $table->string('s_company', 150);
            $table->string('r_company', 150);
            $table->string('s_phone', 20);
            $table->string('r_phone', 20);
            $table->string('s_email', 100);
            $table->string('r_email', 100);
            $table->string('s_region', 100);
            $table->string('r_region', 100);
            $table->string('s_city', 100);
            $table->string('r_city', 100);
            $table->string('s_street', 100);
            $table->string('r_street', 100);
            $table->string('s_building', 20);
            $table->string('r_building', 20);
            $table->string('s_flat', 10);
            $table->string('r_flat', 10);
            $table->string('notification', 10);
            $table->string('service_type', 15);
            $table->text('text');
            $table->string('copy_direction', 8);
            $table->dateTime('copy_date');
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
        Schema::dropIfExists('telegram');
    }
}
