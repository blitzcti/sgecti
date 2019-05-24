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

            $table->bigInteger('id_internship')->nullable(false)->unsigned();
            $table->foreign('id_internship')->references('id')->on('internships');

            $table->date('data_ini');
            $table->date('data_fim');

            $table->bigInteger('id_schedule')->nullable(false)->unsigned();
            $table->foreign('id_schedule')->references('id')->on('schedules');

            $table->string('protocolo', 15);
            $table->text('observacao')->nullable(true)->default(null);

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
