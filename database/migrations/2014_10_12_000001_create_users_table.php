<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!config('broker.useSSO')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('phone', 11)->nullable(true);
                $table->string('password');
                $table->timestamp('password_change_at')->nullable();
                $table->string('api_token', 80)->unique()->nullable();

                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!config('broker.useSSO')) {
            Schema::dropIfExists('users');
        }
    }
}
