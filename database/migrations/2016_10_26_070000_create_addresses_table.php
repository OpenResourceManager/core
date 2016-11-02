<?php

use Illuminate\Support\Facades\Schema;
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
            $table->unsignedInteger('account_id');
            $table->string('addressee', 75)->nullable();
            $table->string('organization', 75)->nullable();
            $table->string('line_1', 75);
            $table->string('line_2', 75)->nullable();
            $table->string('city', 75);
            $table->unsignedInteger('state_id');
            $table->string('zip', 11);
            $table->unsignedInteger('country_id');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_account_id_foreign');
            $table->dropForeign('addresses_state_id_foreign');
            $table->dropForeign('addresses_country_id_foreign');
        });

        Schema::drop('addresses');
    }
}
