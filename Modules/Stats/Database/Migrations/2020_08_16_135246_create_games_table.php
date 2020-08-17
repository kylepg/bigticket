<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('arena_id')->unsigned();
            $table->foreign('arena_id')->references('id')->on('arenas');
            $table->bigInteger('season_id')->unsigned();
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->string('gid')->unique();
            $table->string('gcode')->unique();
            $table->string('season_type');
            $table->dateTime('date_time');
            $table->tinyInteger('round')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->tinyInteger('period')->unsigned()->default(0);
            $table->integer('attendance')->unsigned()->default(0);
            $table->integer('duration')->unsigned()->default(0);
            $table->string('clock')->nullable();
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
        Schema::dropIfExists('games');
    }
}
