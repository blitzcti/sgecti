<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cep', 9)->nullable(false);
            $table->string('uf', 2)->nullable(false);
            $table->string('city', 30)->nullable(false);
            $table->string('street', 50)->nullable(false);
            $table->string('complement', 50)->nullable(true);
            $table->string('number', 6)->nullable(false);
            $table->string('district', 50)->nullable(false);

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
        Schema::dropIfExists('addresses');
    }
}
