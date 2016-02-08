<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedFieldsToRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->boolean('layout_updated')->nullable();
            $table->boolean('design_updated')->nullable();
            $table->boolean('mw_updated')->nullable();
            $table->boolean('field_walk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('layout_updated');
            $table->dropColumn('design_updated');
            $table->dropColumn('mw_updated');
            $table->dropColumn('field_walk');
        });
    }
}
