<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        Schema::drop('apikeys');
    }
}
