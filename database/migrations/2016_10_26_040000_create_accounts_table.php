<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->unique();
            $table->string('name_prefix')->nullable();
            $table->string('name_first');
            $table->string('name_middle')->nullable();
            $table->string('name_last');
            $table->string('name_postfix')->nullable();
            $table->string('name_phonetic')->nullable();
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('ssn')->nullable();
            $table->string('birth_date')->nullable();
            $table->integer('primary_duty_id')->unsigned()->nullable();
            $table->foreign('primary_duty_id')->references('id')->on('duties')->onDelete('set null');
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
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropForeign('accounts_primary_duty_id_foreign');
        });
        Schema::dropIfExists('accounts');
    }
}
