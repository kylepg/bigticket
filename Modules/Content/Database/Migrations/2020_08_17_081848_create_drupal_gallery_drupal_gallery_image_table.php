<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrupalGalleryDrupalGalleryImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drupal_gallery_drupal_gallery_image', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drupal_gallery_id')->unsigned();
            $table->foreign('drupal_gallery_id','dg_id_foreign')->references('id')->on('drupal_galleries');
            $table->bigInteger('drupal_gallery_image_id')->unsigned();
            $table->foreign('drupal_gallery_image_id','dgi_id_foreign')->references('id')->on('drupal_gallery_images');
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
        Schema::dropIfExists('drupal_gallery_drupal_gallery_image');
    }
}
