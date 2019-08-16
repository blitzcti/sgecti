<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ra', 7);

            $table->string('ctps', 13)->nullable(true)->default(null);

            $table->string('company_cpf_cnpj', 15)->nullable(false)->unique();
            $table->string('company_ie', 10)->nullable(true)->default(null)->unique();
            $table->boolean('company_pj')->nullable(false)->default(true);
            $table->string('company_name')->nullable(false);
            $table->string('company_fantasy_name')->nullable(true)->default(null);

            $table->bigInteger('coordinator_id')->nullable(false)->unsigned();
            $table->foreign('coordinator_id')->references('id')->on('coordinators');

            $table->bigInteger('state_id')->nullable(false)->unsigned();
            $table->foreign('state_id')->references('id')->on('states');

            $table->date('start_date');
            $table->date('end_date');

            $table->string('protocol', 15);

            $table->text('activities')->nullable(true)->default(null);
            $table->text('observation')->nullable(true)->default(null);
            $table->text('reason_to_cancel')->nullable(true)->default(null);

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
        Schema::dropIfExists('jobs');
    }
}
