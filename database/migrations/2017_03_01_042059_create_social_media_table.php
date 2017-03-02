<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_media', function (Blueprint $table) {
            $this->generateTable($table);
            $table->longText('title');
            $table->string('post_image_url')->nullable();
            $table->boolean('is_video');
            $table->string('full_link')->nullable();
            $table->string('video_link')->nullable();
            $table->string('separate_image_tag');
            $table->unsignedInteger('fan_page_id');
            $table->unsignedInteger('social_content_type_id');

            $table->foreign('fan_page_id')->references('id')->on('fan_page');
            $table->foreign('social_content_type_id')->references('id')->on('social_content_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_media');
    }
}
