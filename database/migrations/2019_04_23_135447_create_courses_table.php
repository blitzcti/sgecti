<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('color', 6)->nullable(false);

            $table->boolean('active')->nullable(false)->default(true);

            $table->timestamps();
        });

        DB::table('courses')->insert(
            [
                'name' => 'Mecânica',
                'color' => 'red',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        DB::table('courses')->insert([

            'name' => 'Eletrotécnica',
            'color' => 'purple',
            'active' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([

            'name' => 'Edificações',
            'color' => 'yellow',
            'active' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([

            'name' => 'Processamento de dados',
            'color' => 'black',
            'active' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([

            'name' => 'Eletrônica',
            'color' => 'green',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([

            'name' => 'Decoração',
            'color' => 'aqua',
            'active' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('courses')->insert([

            'name' => 'Informática',
            'color' => 'blue',
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
