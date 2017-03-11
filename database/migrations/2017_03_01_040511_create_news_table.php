<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $this->generateTable($table);
            $table->string("post_title");
            $table->text("post_content");
            $table->boolean("is_video");
            $table->string("post_image");
            $table->string("video_link")->nullable();
            $table->string("full_link");
            $table->boolean('is_ads')->default(false);
            $table->string("ads_code")->nullable();

            $table->unsignedInteger("newspaper_id");
            $table->unsignedInteger("category_id");
            $table->unsignedInteger("session_day_id");

            $table->foreign('newspaper_id')->references('id')->on('newspaper');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('session_day_id')->references('id')->on('session_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news');
    }
}
