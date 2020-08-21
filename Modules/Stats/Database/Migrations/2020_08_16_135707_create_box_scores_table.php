<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_scores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->bigInteger('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->bigInteger('player_id')->unsigned();
            $table->foreign('player_id')->references('id')->on('players');
            $table->unique(['game_id','team_id','player_id']);
            $table->string('jersey')->nullable();
            $table->string('position')->nullable();
            $table->integer('total_seconds')->unsigned()->default(0);
            $table->tinyInteger('fga')->unsigned()->default(0);
            $table->tinyInteger('fgm')->unsigned()->default(0);
            $table->tinyInteger('tpa')->unsigned()->default(0);
            $table->tinyInteger('tpm')->unsigned()->default(0);
            $table->tinyInteger('fta')->unsigned()->default(0);
            $table->tinyInteger('ftm')->unsigned()->default(0);
            $table->tinyInteger('oreb')->unsigned()->default(0);
            $table->tinyInteger('dreb')->unsigned()->default(0);
            $table->tinyInteger('reb')->unsigned()->default(0);
            $table->tinyInteger('ast')->unsigned()->default(0);
            $table->tinyInteger('stl')->unsigned()->default(0);
            $table->tinyInteger('blk')->unsigned()->default(0);
            $table->tinyInteger('pf')->unsigned()->default(0);
            $table->tinyInteger('pts')->unsigned()->default(0);
            $table->tinyInteger('tov')->unsigned()->default(0);
            $table->tinyInteger('fbpts')->unsigned()->default(0);
            $table->tinyInteger('fbptsa')->unsigned()->default(0);
            $table->tinyInteger('fbptsm')->unsigned()->default(0);
            $table->tinyInteger('pip')->unsigned()->default(0);
            $table->tinyInteger('pipa')->unsigned()->default(0);
            $table->tinyInteger('pipm')->unsigned()->default(0);
            $table->boolean('is_on_court')->default(false);
            $table->integer('pm')->default(0);
            $table->tinyInteger('blka')->unsigned()->default(0);
            $table->tinyInteger('tf')->unsigned()->default(0);
            $table->string('status')->nullable();
            $table->string('memo')->nullable();
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
        Schema::dropIfExists('box_scores');
    }
}
