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
            $table->softDeletes();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campus_id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('academic');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });

        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number', 11)->unique();
            $table->string('ext', 5)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('building_id');
            $table->unsignedInteger('floor_number')->nullable();
            $table->string('floor_name')->nullable();
            $table->unsignedInteger('room_number');
            $table->string('room_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });

        Schema::create('apikeys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_name')->unique();
            $table->string('key')->unique();
            $table->boolean('can_get');
            $table->boolean('can_post');
            $table->boolean('can_put');
            $table->boolean('can_delete');
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
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropForeign('buildings_campus_id_foreign');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign('programs_department_id_foreign');
        });

        Schema::table('emails', function (Blueprint $table) {
            $table->dropForeign('emails_user_id_foreign');
        });

        Schema::table('phones', function (Blueprint $table) {
            $table->dropForeign('phones_user_id_foreign');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign('rooms_user_id_foreign');
            $table->dropForeign('rooms_building_id_foreign');
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
        Schema::drop('apikeys');
    }
}
