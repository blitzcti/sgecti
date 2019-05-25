<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sectors', function (Blueprint $table) {
            $table->bigInteger('company_id')->nullable(false)->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->bigInteger('sector_id')->nullable(false)->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');

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
        Schema::dropIfExists('company_sectors');
    }
}
