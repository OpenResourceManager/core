<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampusCommunityPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campus_community', function (Blueprint $table) {
            $table->integer('campus_id')->unsigned()->index();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->integer('community_id')->unsigned()->index();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->primary(['campus_id', 'community_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campus_community');
    }
}
