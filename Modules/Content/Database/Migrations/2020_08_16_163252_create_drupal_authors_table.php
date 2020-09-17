<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_authors', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('email')->nullable();
            $table->string('drupal_id')->unique()->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('drupal_authors');
    }
}
