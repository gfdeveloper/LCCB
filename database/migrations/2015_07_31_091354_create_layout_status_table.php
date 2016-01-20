<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->enum('layout_status',['Waiting for Layout Update', 'Waiting for Design Update']);
            $table->integer('submitted_by');
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
        Schema::drop('layout_status');
    }
}
