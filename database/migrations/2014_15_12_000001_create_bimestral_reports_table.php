<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBimestralReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bimestral_reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('internship_id')->nullable(false)->unsigned();
            $table->foreign('internship_id')->references('id')->on('internships');

            $table->date('date');

            $table->string('protocol', 7);

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
        Schema::dropIfExists('bimestral_reports');
    }
}
