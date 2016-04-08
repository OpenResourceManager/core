<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_1');
            $table->unsignedInteger('id_2');
            $table->string('class_1');
            $table->string('class_2');
            $table->string('action');
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
        Schema::drop('pivot_actions');
    }
}
