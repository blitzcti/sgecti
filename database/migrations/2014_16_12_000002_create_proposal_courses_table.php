<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_courses', function (Blueprint $table) {
            $table->bigInteger('proposal_id')->nullable(false)->unsigned();
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('cascade');

            $table->bigInteger('course_id')->nullable(false)->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

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
        Schema::dropIfExists('proposal_courses');
    }
}
