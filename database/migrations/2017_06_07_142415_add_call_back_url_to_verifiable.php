<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCallBackUrlToVerifiable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_phones', function (Blueprint $table) {
            $table->string('verification_callback')->after('verification_token')->nullable();
        });

        Schema::table('emails', function (Blueprint $table) {
            $table->string('verification_callback')->after('verification_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_phones', function ($table) {
            $table->dropColumn('verification_callback');
        });

        Schema::table('emails', function ($table) {
            $table->dropColumn('verification_callback');
        });
    }
}
