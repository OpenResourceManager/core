<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingCommunityPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_community', function (Blueprint $table) {
            $table->integer('building_id')->unsigned()->index();
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->integer('community_id')->unsigned()->index();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->primary(['building_id', 'community_id']);
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
        Schema::drop('building_community');
    }
}
