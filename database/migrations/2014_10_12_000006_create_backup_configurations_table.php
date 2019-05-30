<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backup_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean('sunday')->nullable(false)->default(true);
            $table->boolean('monday')->nullable(false)->default(true);
            $table->boolean('tuesday')->nullable(false)->default(true);
            $table->boolean('wednesday')->nullable(false)->default(true);
            $table->boolean('thursday')->nullable(false)->default(true);
            $table->boolean('friday')->nullable(false)->default(true);
            $table->boolean('saturday')->nullable(false)->default(true);
            $table->time('hour')->nullable(false)->default(Carbon::createFromTime(0, 0));

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
        Schema::dropIfExists('backup_configurations');
    }
}
