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

            $table->bigInteger('company_id')->nullable(false)->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->date('deadline');

            $table->bigInteger('schedule_id')->nullable(true)->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules');

            $table->bigInteger('schedule_2_id')->nullable(true)->unsigned();
            $table->foreign('schedule_2_id')->references('id')->on('schedules');

            $table->float('remuneration')->default(0);
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits');
            $table->text('contact');
            $table->bigInteger('type')->nullable(false)->default(1);
            $table->text('observation')->nullable(true);

            $table->timestamp('approved_at')->nullable(true);
            $table->text('reason_to_reject')->nullable(true);

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
