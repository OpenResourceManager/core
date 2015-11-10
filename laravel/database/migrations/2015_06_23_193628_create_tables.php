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
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campus_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('academic');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('communities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Records

        Schema::create('user_records', function (Blueprint $table) {
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

        Schema::create('email_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('phone_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('number', 11)->unique();
            $table->string('ext', 5)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('role_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('program_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('department_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('department_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_record_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('department_record_id')->references('id')->on('department_records')->onDelete('cascade');
        });

        Schema::create('course_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('room_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('building_id');
            $table->unsignedInteger('floor_number')->nullable();
            $table->string('floor_name')->nullable();
            $table->unsignedInteger('room_number');
            $table->string('room_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });

        Schema::create('community_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('community_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('campus_id')->nullable();
            $table->unsignedInteger('building_id')->nullable();
            $table->unsignedInteger('department_record_id')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('program_record_id')->nullable();
            $table->unsignedInteger('program_id')->nullable();
            $table->unsignedInteger('course_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('department_record_id')->references('id')->on('department_records')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('program_record_id')->references('id')->on('program_records')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('api_key_records', function (Blueprint $table) {
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

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign('courses_department_record_id_foreign');
        });

        Schema::table('email_records', function (Blueprint $table) {
            $table->dropForeign('emails_user_id_foreign');
        });

        Schema::table('phone_records', function (Blueprint $table) {
            $table->dropForeign('phones_user_id_foreign');
        });

        Schema::table('role_records', function (Blueprint $table) {
            $table->dropForeign('role_records_user_id_foreign');
            $table->dropForeign('role_records_role_id_foreign');
        });

        Schema::table('program_records', function (Blueprint $table) {
            $table->dropForeign('program_records_program_id_foreign');
            $table->dropForeign('program_records_user_id_foreign');
        });

        Schema::table('department_records', function (Blueprint $table) {
            $table->dropForeign('department_records_program_id_foreign');
            $table->dropForeign('department_records_department_id_foreign');
        });

        Schema::table('course_records', function (Blueprint $table) {
            $table->dropForeign('course_records_course_id_foreign');
            $table->dropForeign('course_records_user_id_foreign');
        });

        Schema::table('room_records', function (Blueprint $table) {
            $table->dropForeign('rooms_user_id_foreign');
            $table->dropForeign('rooms_building_id_foreign');
        });

        Schema::table('community_records', function (Blueprint $table) {
            $table->dropForeign('community_records_community_id_foreign');
            $table->dropForeign('community_records_user_id_foreign');
            $table->dropForeign('community_records_campus_id_foreign');
            $table->dropForeign('community_records_building_id_foreign');
            $table->dropForeign('community_records_department_record_id_foreign');
            $table->dropForeign('community_records_department_id_foreign');
            $table->dropForeign('community_records_program_record_id_foreign');
            $table->dropForeign('community_records_program_id_foreign');
            $table->dropForeign('community_records_course_id_foreign');
            $table->dropForeign('community_records_role_id_foreign');
        });

        Schema::drop('api_key_records');
        Schema::drop('community_records');
        Schema::drop('user_records');
        Schema::drop('email_records');
        Schema::drop('phone_records');
        Schema::drop('role_records');
        Schema::drop('department_records');
        Schema::drop('program_records');
        Schema::drop('course_records');
        Schema::drop('room_records');

        Schema::drop('courses');
        Schema::drop('roles');
        Schema::drop('communities');
        Schema::drop('buildings');
        Schema::drop('campuses');
        Schema::drop('programs');
        Schema::drop('departments');
    }
}
