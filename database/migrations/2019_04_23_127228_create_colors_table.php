<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
        });

        DB::table('colors')->insert(
            ['name' => 'blue']
        );

        DB::table('colors')->insert(
            ['name' => 'purple']
        );

        DB::table('colors')->insert(
            ['name' => 'red']
        );

        DB::table('colors')->insert(
            ['name' => 'orange']
        );

        DB::table('colors')->insert(
            ['name' => 'yellow']
        );

        DB::table('colors')->insert(
            ['name' => 'green']
        );

        DB::table('colors')->insert(
            ['name' => 'teal']
        );

        DB::table('colors')->insert(
            ['name' => 'lime']
        );

        DB::table('colors')->insert(
            ['name' => 'cyan']
        );

        DB::table('colors')->insert(
            ['name' => 'aqua']
        );

        DB::table('colors')->insert(
            ['name' => 'black']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
