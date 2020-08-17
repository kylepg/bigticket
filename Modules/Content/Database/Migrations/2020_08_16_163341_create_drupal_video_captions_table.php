<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalVideoCaptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_video_captions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('sidecar_scc_url')->nullable();
            $table->longText('sidecar_scc')->nullable();
            $table->string('sidecar_webvtt_url')->nullable();
            $table->longText('sidecar_webvtt')->nullable();
            $table->bigInteger('drupal_video_id')->unsigned();
            $table->foreign('drupal_video_id')->references('id')->on('drupal_videos');
            $table->boolean('is_locally_edited')->default(false);
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
        Schema::dropIfExists('drupal_video_captions');
    }
}
