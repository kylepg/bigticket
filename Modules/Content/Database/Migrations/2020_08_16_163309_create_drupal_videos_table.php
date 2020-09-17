<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_videos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('drupal_uuid')->unique()->nullable();
            $table->string('team')->nullable();
            $table->string('nid')->nullable();
            $table->string('title')->nullable();
            $table->string('headline')->nullable();
            $table->string('short_headline')->nullable();
            $table->text('description')->nullable();
            $table->string('api_uri')->nullable();
            $table->string('content_xml')->nullable();
            $table->string('video_id')->nullable();
            $table->string('video_source')->nullable();
            $table->string('brand')->nullable();
            $table->string('url')->nullable();
            $table->integer('runtime')->unsigned()->default(0);
            $table->string('image_url')->nullable();
            $table->string('image_focal_point')->nullable();
            $table->boolean('drupal_published')->default(true);
            $table->timestamp('drupal_published_at')->nullable();
            $table->timestamp('drupal_changed_at')->nullable();
            $table->bigInteger('drupal_author_id')->unsigned()->nullable();
            $table->foreign('drupal_author_id')->references('id')->on('drupal_authors');
            $table->boolean('is_locally_edited')->default(false);
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
        Schema::dropIfExists('drupal_videos');
    }
}
