<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nome', 50)->nullable(false);
            $table->string('email', 50)->nullable(false);
            $table->string('telefone', 11)->nullable(false);
            $table->string('ramal', 50)->nullable(true)->default(null);
            $table->boolean('ativo', 100)->nullable(false)->default(true);

            $table->bigInteger('id_company')->nullable(false)->unsigned();
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');

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
        Schema::dropIfExists('supervisors');
    }
}
