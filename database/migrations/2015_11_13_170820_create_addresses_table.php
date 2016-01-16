<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('addressee', 50)->nullable();
            $table->string('organization', 50)->nullable();
            $table->string('line_1', 50);
            $table->string('line_2', 50)->nullable();
            $table->string('city', 50);
            $table->unsignedInteger('state_id');
            $table->string('zip', 11);
            $table->unsignedInteger('country_id');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('users_address_id_foreign');
            $table->dropForeign('states_address_id_foreign');
            $table->dropForeign('countries_address_id_foreign');
        });

        Schema::drop('address');
    }
}
