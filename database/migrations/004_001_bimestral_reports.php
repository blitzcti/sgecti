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

            $table->bigInteger('id_internship')->nullable(false)->unsigned();
            $table->foreign('id_internship')->references('id')->on('internships');

            $table->date('dia');

            $table->string('protocolo', 15);

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
