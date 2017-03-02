<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_page', function (Blueprint $table) {
            $this->generateTable($table);
            $table->string("name");
            $table->string("logo");
            $table->unsignedInteger("social_info_id");

            $table->foreign("social_info_id")->references('id')->on('social_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fan_page');
    }
}
