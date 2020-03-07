<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('internship_id')->nullable(false)->unsigned();
            $table->foreign('internship_id')->references('id')->on('internships')->onUpdate('cascade')->onUpdate('cascade')->onDelete('cascade');

            $table->date('date');

            $table->integer('grade_1_a');
            $table->integer('grade_1_b');
            $table->integer('grade_1_c');
            $table->integer('grade_2_a');
            $table->integer('grade_2_b');
            $table->integer('grade_2_c');
            $table->integer('grade_2_d');
            $table->integer('grade_3_a');
            $table->integer('grade_3_b');
            $table->integer('grade_4_a');
            $table->integer('grade_4_b');
            $table->integer('grade_4_c');
            $table->float('final_grade');

            $table->integer('completed_hours');
            $table->date('end_date');
            $table->string('approval_number', '8');

            $table->bigInteger('coordinator_id')->nullable(false)->unsigned();
            $table->foreign('coordinator_id')->references('id')->on('coordinators')->onUpdate('cascade')->onDelete('cascade');

            $table->text('observation')->nullable(true);

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
        Schema::dropIfExists('final_reports');
    }
}
