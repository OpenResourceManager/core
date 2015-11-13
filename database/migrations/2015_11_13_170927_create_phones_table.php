<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number', 11)->unique();
            $table->string('ext', 5)->nullable();
            $table->boolean('is_cell')->nullable();
            $table->string('carrier', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phones', function (Blueprint $table) {
            $table->dropForeign('phones_user_id_foreign');
        });

        Schema::drop('phones');
    }
}
