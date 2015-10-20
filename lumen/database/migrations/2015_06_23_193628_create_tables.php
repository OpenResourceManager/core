<?php use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
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
            $table->string('name_phonetic')->nullable();
            $table->string('username')->unique();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('campuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campus');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->foreign('campus')->references('id')->on('campuses');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('academic');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->foreign('department')->references('id')->on('departments');
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->string('email')->unique();
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users');
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->string('number', 11)->unique();
            $table->string('ext', 5)->nullable();
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users');
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('building');
            $table->unsignedInteger('floor_number')->nullable();
            $table->string('floor_name')->nullable();
            $table->unsignedInteger('room_number');
            $table->string('room_name')->nullable();
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('building')->references('id')->on('buildings');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropForeign('buildings_campus_foreign');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign('programs_department_foreign');
        });

        Schema::table('emails', function (Blueprint $table) {
            $table->dropForeign('emails_user_foreign');
        });

        Schema::table('phones', function (Blueprint $table) {
            $table->dropForeign('phones_user_foreign');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign('rooms_user_foreign');
            $table->dropForeign('rooms_building_foreign');
        });

        Schema::drop('users');
        Schema::drop('roles');
        Schema::drop('campuses');
        Schema::drop('buildings');
        Schema::drop('departments');
        Schema::drop('programs');
        Schema::drop('emails');
        Schema::drop('phones');
        Schema::drop('rooms');
    }
}