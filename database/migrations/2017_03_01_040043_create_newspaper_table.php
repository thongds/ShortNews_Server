<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewspaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newspaper', function (Blueprint $table) {
            $this->generateTable($table);
            $table->string("name");
            $table->string("title_color");
            $table->string("paper_logo");
            $table->string("paper_tag_color");
            $table->string("video_tag_image");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('newspaper');
    }
}
