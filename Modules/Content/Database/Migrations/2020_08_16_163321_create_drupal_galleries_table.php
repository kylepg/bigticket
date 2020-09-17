<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('drupal_uuid')->unique()->nullable();
            $table->string('team')->nullable();
            $table->string('nid')->nullable();
            $table->string('title')->nullable();
            $table->string('headline')->nullable();
            $table->text('teaser')->nullable();
            $table->text('caption')->nullable();
            $table->string('credit')->nullable();
            $table->string('api_uri')->nullable();
            $table->string('brand')->nullable();
            $table->string('url')->nullable();
            $table->string('image_url')->nullable();
            $table->string('image_focal_point')->nullable();
            $table->boolean('drupal_published')->default(true);
            $table->timestamp('drupal_published_at')->nullable();
            $table->timestamp('drupal_changed_at')->nullable();
            $table->bigInteger('drupal_author_id')->unsigned()->nullable();
            $table->foreign('drupal_author_id')->references('id')->on('drupal_authors');
            $table->boolean('is_visible')->default(true);
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
        Schema::dropIfExists('drupal_galleries');
    }
}
