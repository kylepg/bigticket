<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_team', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games');
            $table->bigInteger('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
            $table->string('role');
            $table->tinyInteger('s')->unsigned()->default(0);
            $table->tinyInteger('q1')->unsigned()->default(0);
            $table->tinyInteger('q2')->unsigned()->default(0);
            $table->tinyInteger('q3')->unsigned()->default(0);
            $table->tinyInteger('q4')->unsigned()->default(0);
            $table->tinyInteger('ot1')->unsigned()->default(0);
            $table->tinyInteger('ot2')->unsigned()->default(0);
            $table->tinyInteger('ot3')->unsigned()->default(0);
            $table->tinyInteger('ot4')->unsigned()->default(0);
            $table->tinyInteger('ot5')->unsigned()->default(0);
            $table->tinyInteger('ot6')->unsigned()->default(0);
            $table->tinyInteger('ot7')->unsigned()->default(0);
            $table->tinyInteger('ot8')->unsigned()->default(0);
            $table->tinyInteger('ot9')->unsigned()->default(0);
            $table->tinyInteger('ot10')->unsigned()->default(0);
            $table->tinyInteger('ftout')->default(0);
            $table->tinyInteger('stout')->default(0);
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
            $table->tinyInteger('tov')->unsigned()->default(0);
            $table->tinyInteger('fbpts')->unsigned()->default(0);
            $table->tinyInteger('fbptsa')->unsigned()->default(0);
            $table->tinyInteger('fbptsm')->unsigned()->default(0);
            $table->tinyInteger('pip')->unsigned()->default(0);
            $table->tinyInteger('pipa')->unsigned()->default(0);
            $table->tinyInteger('pipm')->unsigned()->default(0);
            $table->tinyInteger('ble')->unsigned()->default(0);
            $table->tinyInteger('bpts')->unsigned()->default(0);
            $table->tinyInteger('tf')->unsigned()->default(0);
            $table->tinyInteger('scp')->unsigned()->default(0);
            $table->tinyInteger('tmreb')->unsigned()->default(0);
            $table->tinyInteger('tmtov')->unsigned()->default(0);
            $table->tinyInteger('potov')->unsigned()->default(0);
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
        Schema::dropIfExists('game_team');
    }
}
