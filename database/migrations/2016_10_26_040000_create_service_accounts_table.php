<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->string('identifier')->unique();
            $table->string('username')->unique();
            $table->string('name_first');
            $table->string('name_last');
            $table->string('password')->nullable();
            $table->boolean('should_propagate_password')->default(false);
            $table->dateTime('expires_at')->nullable();
            $table->boolean('disabled')->default(false);
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::table('service_accounts', function (Blueprint $table) {
            $table->dropForeign('service_accounts_account_id_foreign');
        });
        Schema::dropIfExists('service_accounts');
    }
}
