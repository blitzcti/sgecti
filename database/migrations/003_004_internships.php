<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ra', 7);

            $table->bigInteger('id_ctps')->nullable(true)->default(null)->unsigned();
            $table->foreign('id_ctps')->references('id')->on('ctps');

            $table->bigInteger('id_company')->nullable(false)->unsigned();
            $table->foreign('id_company')->references('id')->on('company');

            $table->bigInteger('id_sector')->nullable(false)->unsigned();
            $table->foreign('id_sector')->references('id')->on('sector');

            $table->bigInteger('id_coordinator')->nullable(false)->unsigned();
            $table->foreign('id_coordinator')->references('id')->on('coordinator');

            $table->bigInteger('id_schedule')->nullable(false)->unsigned();
            $table->foreign('id_schedule')->references('id')->on('schedule');

            $table->bigInteger('id_state')->nullable(false)->unsigned();
            $table->foreign('id_state')->references('id')->on('state');

            $table->date('data_ini');
            $table->date('data_fim');

            $table->string('protocolo', 15);

            $table->text('atividades');
            $table->text('observacao')->nullable(true)->default(null);
            $table->text('motivo_cancelamento')->nullable(true)->default(null);

            $table->boolean('ativo')->default(true);

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
        Schema::dropIfExists('internships');
    }
}
