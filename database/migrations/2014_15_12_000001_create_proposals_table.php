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

            $table->bigInteger('course_id')->nullable(false)->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');

            $table->date('deadline');

            $table->bigInteger('schedule_id')->nullable(false)->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules');

            $table->float('remuneration')->default(0);
            $table->text('description');
            $table->text('observation')->nullable(true)->default(null);

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
