<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->unsignedInteger('floor_number')->nullable();
            $table->string('floor_name')->nullable();
            $table->unsignedInteger('room_number');
            $table->string('room_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign('rooms_building_id_foreign');
        });

        Schema::drop('rooms');
    }
}
