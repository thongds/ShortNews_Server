<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_info', function (Blueprint $table) {
            $this->generateTable($table);
            $table->string("name");
            $table->string("logo");
            $table->string("video_tag");
            $table->string("color_tag");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_info');
    }
}
