<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_courses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('id_company')->nullable(false)->unsigned();
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('cascade');

            $table->bigInteger('id_course')->nullable(false)->unsigned();
            $table->foreign('id_course')->references('id')->on('courses')->onDelete('cascade');

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
        Schema::dropIfExists('company_courses');
    }
}
