<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name', 30)->nullable(false);
            $table->bigInteger('id_color')->nullable(false)->unsigned();;
            $table->foreign('id_color')->references('id')->on('colors');

            $table->boolean('active')->nullable(false)->default(true);

            $table->timestamps();
        });

        DB::table('courses')->insert([
            'name'       => 'Mecânica',
            'id_color'   => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Eletrotécnica',
            'id_color'   => 2,
            'active'     => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Edificações',
            'id_color'   => 5,
            'active'     => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Processamento de dados',
            'id_color'   => 11,
            'active'     => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Eletrônica',
            'id_color'   => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Decoração',
            'id_color'   => 10,
            'active'     => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([
            'name'       => 'Informática',
            'id_color'   => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
