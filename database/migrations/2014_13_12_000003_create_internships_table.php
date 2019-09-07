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

            $table->bigInteger('company_id')->nullable(false)->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->bigInteger('sector_id')->nullable(false)->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->bigInteger('coordinator_id')->nullable(false)->unsigned();
            $table->foreign('coordinator_id')->references('id')->on('coordinators');

            $table->bigInteger('schedule_id')->nullable(false)->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules');

            $table->bigInteger('schedule_2_id')->nullable(true)->default(null)->unsigned();
            $table->foreign('schedule_2_id')->references('id')->on('schedules');

            $table->bigInteger('state_id')->nullable(false)->unsigned();
            $table->foreign('state_id')->references('id')->on('states');

            $table->bigInteger('supervisor_id')->nullable(false)->unsigned();
            $table->foreign('supervisor_id')->references('id')->on('supervisors');

            $table->date('start_date');
            $table->date('end_date');

            $table->string('protocol', 7);

            $table->text('activities');
            $table->text('observation')->nullable(true)->default(null);
            $table->text('reason_to_cancel')->nullable(true)->default(null);
            $table->date('canceled_at')->nullable(true)->default(null);

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
        Schema::dropIfExists('internships');
    }
}
