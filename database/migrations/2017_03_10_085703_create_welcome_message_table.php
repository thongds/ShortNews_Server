<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelcomeMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welcome_message', function (Blueprint $table) {

            $this->generateTable($table);
            $table->string("welcome_msg");
            $table->string("event_msg")->nullable();
            $table->string("avatar_morning");
            $table->string("avatar_morning_path");
            $table->string("avatar_night");
            $table->string("avatar_night_path");
            $table->tinyInteger("type");//social or news?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('welcome_message');
    }
}
