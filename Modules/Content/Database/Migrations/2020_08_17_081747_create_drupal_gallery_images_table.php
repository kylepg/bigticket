<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalGalleryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('source_url')->nullable();
            $table->string('raw_image_url')->unique()->nullable();
            $table->string('raw_image_focal_point')->nullable();
            $table->string('tile_image_url')->nullable();
            $table->string('mobile_image_url')->nullable();
            $table->string('portrait_image_url')->nullable();
            $table->string('landscape_image_url')->nullable();
            $table->text('caption')->nullable();
            $table->text('alt_text')->nullable();
            $table->text('credit')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('drupal_gallery_images');
    }
}
