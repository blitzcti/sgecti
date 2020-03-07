<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_companies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cpf_cnpj', 15)->nullable(false)->unique();
            $table->string('ie', 20)->nullable(true)->unique();
            $table->boolean('pj')->nullable(false)->default(true);
            $table->string('name')->nullable(false);
            $table->string('fantasy_name')->nullable(true);

            $table->string('representative_name', 50)->nullable(false);
            $table->string('representative_role', 50)->nullable(false);

            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('job_companies');
    }
}
