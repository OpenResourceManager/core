<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class V1111 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Add verification stuff to phones
         */
        Schema::table('phones', function (Blueprint $table) {
            $table->string('country_code', 4)->nullable()->after('user_id');
            $table->boolean('verified')->default(false)->after('is_cell');
            $table->string('verification_token', 6)->nullable()->after('verified');
        });
        /**
         * Add verification stuff to emails
         */
        Schema::table('emails', function (Blueprint $table) {
            $table->boolean('verified')->default(false)->after('email');
            $table->string('verification_token', 6)->nullable()->after('verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
