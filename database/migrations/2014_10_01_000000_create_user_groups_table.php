<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', '30')->nullable(false);
            $table->string('description', '200')->nullable(true);
            $table->timestamps();
        });

        DB::table('user_groups')->insert(
            ['name' => 'Administrador'],
            ['description' => 'Administra o sistema (root)']
        );

        DB::table('user_groups')->insert(
            ['name' => 'Professor'],
            ['description' => 'Professor de uma disciplina técnica']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_groups');
    }
}
