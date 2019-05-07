<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nome', 60)->nullable(false);
            $table->string('cep', 9)->nullable(false);
            $table->string('uf', 2)->nullable(false);
            $table->string('cidade', 30)->nullable(false);
            $table->string('rua', 50)->nullable(false);
            $table->string('numero', 6)->nullable(false);
            $table->string('bairro', 50)->nullable(false);
            $table->string('fone', 11)->nullable(false);
            $table->string('email', 50)->nullable(false);
            $table->string('ramal', 5)->nullable(true)->default(null);
            $table->integer('validade_convenio')->nullable(false);
            $table->date('ultimo_backup')->nullable(true)->default(null);

            $table->timestamps();
        });

        DB::table('system_configurations')->insert([
            'nome' => 'Colégio Técnico Industrial "Prof. Isaac Portal Roldán"',
            'cep' => '17033260',
            'uf' => 'SP',
            'cidade' => 'Bauru',
            'rua' => 'Avenida Nações Unidas - de Quadra 43 ao fim',
            'numero' => '58-50',
            'bairro' => 'Núcleo Residencial Presidente Geisel',
            'fone' => '1431036150',
            'email' => 'dir_cti@feb.unesp.com.br',
            'validade_convenio' => '5'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_configurations');
    }
}
