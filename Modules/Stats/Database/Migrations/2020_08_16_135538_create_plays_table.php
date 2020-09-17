<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->unique(['event_id','game_id']);
            $table->bigInteger('team_id')->unsigned()->nullable();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->tinyInteger('period')->unsigned();
            $table->string('clock');
            $table->float('seconds')->default(0);
            $table->string('description');
            $table->integer('x_coordinate');
            $table->integer('y_coordinate');
            $table->tinyInteger('home_score')->unsigned();
            $table->tinyInteger('visitor_score')->unsigned();
            $table->integer('event_type_id')->nullable();
            $table->integer('action_type_id')->nullable();
            $table->integer('option_1')->nullable();
            $table->integer('option_2')->nullable();
            $table->integer('option_3')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('plays');
    }
}
