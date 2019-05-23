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

            $table->time('seg_e')->nullable(true)->default(null);
            $table->time('seg_s')->nullable(true)->default(null);

            $table->time('ter_e')->nullable(true)->default(null);
            $table->time('ter_s')->nullable(true)->default(null);

            $table->time('qua_e')->nullable(true)->default(null);
            $table->time('qua_s')->nullable(true)->default(null);

            $table->time('qui_e')->nullable(true)->default(null);
            $table->time('qui_s')->nullable(true)->default(null);

            $table->time('sex_e')->nullable(true)->default(null);
            $table->time('sex_s')->nullable(true)->default(null);

            $table->time('sab_e')->nullable(true)->default(null);
            $table->time('sab_s')->nullable(true)->default(null);

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
