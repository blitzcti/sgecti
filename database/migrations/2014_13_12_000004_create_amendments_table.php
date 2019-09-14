<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmendmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amendments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('internship_id')->nullable(false)->unsigned();
            $table->foreign('internship_id')->references('id')->on('internships')->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');
            $table->date('new_end_date')->nullable(true)->default(null);

            $table->bigInteger('schedule_id')->nullable(true)->default(null)->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');

            $table->bigInteger('schedule_2_id')->nullable(true)->default(null)->unsigned();
            $table->foreign('schedule_2_id')->references('id')->on('schedules')->onDelete('cascade');

            $table->string('protocol', 7);
            $table->text('observation')->nullable(true)->default(null);

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
        Schema::dropIfExists('amendments');
    }
}
