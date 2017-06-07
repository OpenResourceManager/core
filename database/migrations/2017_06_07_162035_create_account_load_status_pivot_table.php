<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountLoadStatusPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_load_status', function (Blueprint $table) {
            $table->integer('load_status_id')->unsigned()->index();
            $table->foreign('load_status_id')->references('id')->on('load_statuses')->onDelete('cascade');
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->primary(['load_status_id', 'account_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_load_status', function (Blueprint $table) {
            $table->dropForeign('account_load_status_account_id_foreign');
            $table->dropForeign('account_load_status_load_status_id_foreign');
            $table->drop();
        });
    }
}
