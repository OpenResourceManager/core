<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sageid')->unique();
            $table->boolean('active');
            $table->string('name_prefix')->nullable();
            $table->string('name_first');
            $table->string('name_middle')->nullable();
            $table->string('name_last');
            $table->string('name_postfix')->nullable();
            $table->string('name_phonetic')->nullable();
            $table->string('username')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
