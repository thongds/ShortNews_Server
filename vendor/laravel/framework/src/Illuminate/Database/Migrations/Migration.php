<?php

namespace Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;

abstract class Migration
{
    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection;

    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection()
    {
        return $this->connection;
    }
    public function generateTable(Blueprint $table){
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->dateTime('created_at');
        $table->dateTime('updated_at');
        $table->boolean('active')->default(1);
    }
}
