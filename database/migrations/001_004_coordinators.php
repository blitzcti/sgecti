<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinators', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_user')->nullable(false)->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('id_course')->nullable(false)->unsigned();
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');

            $table->date('vigencia_ini')->nullable(false);
            $table->date('vigencia_fim')->nullable(true)->default(null);

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
        Schema::dropIfExists('coordinators');
    }
}
