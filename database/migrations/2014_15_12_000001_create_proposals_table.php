<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_company')->nullable(false)->unsigned();
            $table->foreign('id_company')->references('id')->on('companies');

            $table->bigInteger('id_course')->nullable(false)->unsigned();
            $table->foreign('id_course')->references('id')->on('courses');

            $table->date('data_limite');

            $table->bigInteger('id_schedule')->nullable(false)->unsigned();
            $table->foreign('id_schedule')->references('id')->on('schedule');

            $table->float('remuneracao')->default(0);
            $table->text('descricao');
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
        Schema::dropIfExists('proposals');
    }
}
