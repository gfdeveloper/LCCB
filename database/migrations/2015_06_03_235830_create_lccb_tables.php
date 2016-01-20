<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLccbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('submitted_by');
            $table->integer('functional_id');
            $table->integer('location_id');
            $table->integer('category_id');
            $table->integer('equipment_id');
            $table->string('schedule_impact');
            $table->string('requester_name');
            $table->smallInteger('status_id');
            $table->float('cost_rom');
            $table->text('description');
            $table->text('business_need');
            $table->text('if_not_done');
            $table->text('alternatives');
            $table->dateTime('requested_on');
            $table->dateTime('approved_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

	    Schema::create('comments', function (Blueprint $table){
		    $table->increments('id');
		    $table->integer('request_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->text('comment');
		    $table->timestamps();
	    });

        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->string('file_name');
            $table->timestamps();
        });

	    Schema::create('equipment', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('user_id');
		    $table->string('name')->unique();
		    $table->timestamps();
	    });

        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('user_id');
            $table->integer('organization_id');
	        $table->boolean('approved_offline');
            $table->enum('choice',
                [
                    'Approve',
                    'Reject'
                ]
            );
            $table->text('comment')->nullable();
            $table->timestamps();
        });

	    Schema::create('locations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->timestamps();
	    });

	    Schema::create('categories', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->timestamps();
	    });

	    Schema::create('areas', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->timestamps();
	    });

	    Schema::create('status', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->string('slug');
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
        Schema::drop('requests');
        Schema::drop('organizations');
        Schema::drop('uploads');
        Schema::drop('approvals');
	    Schema::drop('equipment');
	    Schema::drop('locations');
	    Schema::drop('areas');
	    Schema::drop('categories');
	    Schema::drop('status');
	    Schema::drop('comments');
    }
}
