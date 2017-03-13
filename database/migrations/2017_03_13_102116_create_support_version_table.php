<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_version', function (Blueprint $table) {
            $table->string("version");
            $table->longText("link_update");
            $table->longText("message_update");
            $table->unsignedInteger("platform_id");
            $table->foreign('platform_id')->references('id')->on('platform');
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
        Schema::drop('support_version');
    }
}
