<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cpf_cnpj', 15)->nullable(false)->unique();
            $table->boolean('pj')->nullable(false)->default(true);

            $table->string('nome', 100)->nullable(false);
            $table->string('nome_fantasia', 100)->nullable(true)->default(null);
            $table->string('email', 100)->nullable(false);
            $table->string('telefone', 11)->nullable(false);

            $table->string('representante', 50)->nullable(false);
            $table->string('cargo', 50)->nullable(false);

            $table->boolean('ativo')->nullable(false)->default(true);

            $table->bigInteger('id_adress')->nullable(false)->unsigned();
            $table->foreign('id_adress')->references('id')->on('adresses')->onDelete('cascade');

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
        Schema::dropIfExists('companies');
    }
}
