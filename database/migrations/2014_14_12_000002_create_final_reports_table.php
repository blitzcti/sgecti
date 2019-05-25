<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('internship_id')->nullable(false)->unsigned();
            $table->foreign('internship_id')->references('id')->on('internships');

            $table->date('dia');

            $table->integer('nota_1_a');
            $table->integer('nota_1_b');
            $table->integer('nota_1_c');
            $table->integer('nota_2_a');
            $table->integer('nota_2_b');
            $table->integer('nota_2_c');
            $table->integer('nota_2_d');
            $table->integer('nota_3_a');
            $table->integer('nota_3_b');
            $table->integer('nota_4_a');
            $table->integer('nota_4_b');
            $table->integer('nota_4_c');
            $table->integer('nota_final');

            $table->integer('horas_cumpridas');
            $table->date('data_termino');
            $table->string('numero_aprovacao');

            $table->bigInteger('coordinator_id')->nullable(false)->unsigned();
            $table->foreign('coordinator_id')->references('id')->on('coordinators');

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
        Schema::dropIfExists('final_reports');
    }
}
