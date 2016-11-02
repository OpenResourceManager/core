<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountCoursePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_course', function (Blueprint $table) {
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('account_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->primary(['course_id', 'account_id']);
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
        Schema::table('account_course', function (Blueprint $table) {
            $table->dropForeign('account_course_account_id_foreign');
            $table->dropForeign('account_course_course_id_foreign');
            $table->drop();
        });
    }
}
