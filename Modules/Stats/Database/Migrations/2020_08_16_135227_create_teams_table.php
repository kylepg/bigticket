<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('tid')->unique();
            $table->string('name');
            $table->string('location');
            $table->string('abbreviation')->unique();
            $table->unique(['name','location']);
            $table->string('primary_color')->default('#000000');
            $table->string('secondary_color')->default('#ffffff');
            $table->bigInteger('league_id')->unsigned()->nullable();
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->bigInteger('arena_id')->unsigned()->nullable();
            $table->foreign('arena_id')->references('id')->on('arenas');
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
        Schema::dropIfExists('teams');
    }
}
