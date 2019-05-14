<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('id_group')->nullable(false)->default(2)->unsigned(); //Default = Teacher (2)
            $table->foreign('id_group')->references('id')->on('user_groups')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });

        $user = new App\User();
        $user->password = Hash::make('123456789'); //Admin password
        $user->email = 'admin@localhost.com';
        $user->name = 'Administrador';
        $user->id_group = 1;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
