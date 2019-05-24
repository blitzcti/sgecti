<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_course')->nullable(false)->unsigned();
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');

            $table->integer('min_year')->nullable(false);
            $table->integer('min_semester')->nullable(false);

            $table->integer('min_hours')->nullable(false);
            $table->integer('min_months')->nullable(false);
            $table->integer('min_months_ctps')->nullable(false);

            $table->integer('min_grade')->nullable(false);

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
        Schema::dropIfExists('course_configurations');
    }
}
