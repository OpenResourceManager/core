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
            $table->boolean('can_view_address')->default(false);
            $table->boolean('can_post_address')->default(false);
            $table->boolean('can_delete_address')->default(false);
            $table->boolean('can_view_building')->default(false);
            $table->boolean('can_post_building')->default(false);
            $table->boolean('can_delete_building')->default(false);
            $table->boolean('can_view_campus')->default(false);
            $table->boolean('can_post_campus')->default(false);
            $table->boolean('can_delete_campus')->default(false);
            $table->boolean('can_view_country')->default(false);
            $table->boolean('can_post_country')->default(false);
            $table->boolean('can_delete_country')->default(false);
            $table->boolean('can_view_course')->default(false);
            $table->boolean('can_post_course')->default(false);
            $table->boolean('can_delete_course')->default(false);
            $table->boolean('can_view_department')->default(false);
            $table->boolean('can_post_department')->default(false);
            $table->boolean('can_delete_department')->default(false);
            $table->boolean('can_view_email')->default(false);
            $table->boolean('can_post_email')->default(false);
            $table->boolean('can_delete_email')->default(false);
            $table->boolean('can_view_password')->default(false);
            $table->boolean('can_post_password')->default(false);
            $table->boolean('can_delete_password')->default(false);
            $table->boolean('can_view_phone')->default(false);
            $table->boolean('can_post_phone')->default(false);
            $table->boolean('can_delete_phone')->default(false);
            $table->boolean('can_view_role')->default(false);
            $table->boolean('can_post_role')->default(false);
            $table->boolean('can_delete_role')->default(false);
            $table->boolean('can_view_room')->default(false);
            $table->boolean('can_post_room')->default(false);
            $table->boolean('can_delete_room')->default(false);
            $table->boolean('can_view_state')->default(false);
            $table->boolean('can_post_state')->default(false);
            $table->boolean('can_delete_state')->default(false);
            $table->boolean('can_view_user')->default(false);
            $table->boolean('can_post_user')->default(false);
            $table->boolean('can_delete_user')->default(false);
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
