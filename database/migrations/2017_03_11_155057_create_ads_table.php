<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement', function (Blueprint $table) {
            $table->string("post_image");
            $table->string("post_image_path");
            $table->string("ads_host");
            $table->string("full_link");
            $table->tinyInteger("type");
            $table->tinyInteger("at_page");
            $table->tinyInteger("at_position");
            $table->string("ads_host");
            $table->string("ads_code");
            $this->generateTable($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('advertisement');
    }
}
