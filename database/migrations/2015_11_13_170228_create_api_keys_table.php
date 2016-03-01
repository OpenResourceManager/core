<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_name')->unique();
            $table->string('key')->unique();
            $table->boolean('can_get')->default(false);
            $table->boolean('can_post')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_get_address')->default(false);
            $table->boolean('can_post_address')->default(false);
            $table->boolean('can_delete_address')->default(false);
            $table->boolean('can_get_building')->default(false);
            $table->boolean('can_post_building')->default(false);
            $table->boolean('can_delete_building')->default(false);
            $table->boolean('can_get_campus')->default(false);
            $table->boolean('can_post_campus')->default(false);
            $table->boolean('can_delete_campus')->default(false);
            $table->boolean('can_get_country')->default(false);
            $table->boolean('can_post_country')->default(false);
            $table->boolean('can_delete_country')->default(false);
            $table->boolean('can_get_course')->default(false);
            $table->boolean('can_post_course')->default(false);
            $table->boolean('can_delete_course')->default(false);
            $table->boolean('can_get_department')->default(false);
            $table->boolean('can_post_department')->default(false);
            $table->boolean('can_delete_department')->default(false);
            $table->boolean('can_get_email')->default(false);
            $table->boolean('can_post_email')->default(false);
            $table->boolean('can_delete_email')->default(false);
            $table->boolean('can_get_password')->default(false);
            $table->boolean('can_post_password')->default(false);
            $table->boolean('can_delete_password')->default(false);
            $table->boolean('can_get_birth_date')->default(false);
            $table->boolean('can_post_birth_date')->default(false);
            $table->boolean('can_delete_birth_date')->default(false);
            $table->boolean('can_get_phone')->default(false);
            $table->boolean('can_post_phone')->default(false);
            $table->boolean('can_delete_phone')->default(false);
            $table->boolean('can_get_role')->default(false);
            $table->boolean('can_post_role')->default(false);
            $table->boolean('can_delete_role')->default(false);
            $table->boolean('can_get_room')->default(false);
            $table->boolean('can_post_room')->default(false);
            $table->boolean('can_delete_room')->default(false);
            $table->boolean('can_get_state')->default(false);
            $table->boolean('can_post_state')->default(false);
            $table->boolean('can_delete_state')->default(false);
            $table->boolean('can_get_user')->default(false);
            $table->boolean('can_post_user')->default(false);
            $table->boolean('can_delete_user')->default(false);
            $table->boolean('can_get_mobile_carrier')->default(false);
            $table->boolean('can_post_mobile_carrier')->default(false);
            $table->boolean('can_delete_mobile_carrier')->default(false);
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
        Schema::drop('api_keys');
    }
}
