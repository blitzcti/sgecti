<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->time('mon_s')->nullable(true);
            $table->time('mon_e')->nullable(true);

            $table->time('tue_s')->nullable(true);
            $table->time('tue_e')->nullable(true);

            $table->time('wed_s')->nullable(true);
            $table->time('wed_e')->nullable(true);

            $table->time('thu_s')->nullable(true);
            $table->time('thu_e')->nullable(true);

            $table->time('fri_s')->nullable(true);
            $table->time('fri_e')->nullable(true);

            $table->time('sat_s')->nullable(true);
            $table->time('sat_e')->nullable(true);

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
        Schema::dropIfExists('schedules');
    }
}
