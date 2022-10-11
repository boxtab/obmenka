<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PsCurrenciesRenameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_currencies', function (Blueprint $table) {
            $table->dropForeign(['payment_system_id']);
            $table->dropForeign(['currency_id']);

            $table->dropForeign(['created_user_id']);
            $table->dropForeign(['updated_user_id']);
            $table->dropForeign(['deleted_user_id']);
        });

        Schema::rename('ps_currencies', 'direction');

        Schema::table('direction', function (Blueprint $table) {
            $table->foreign('payment_system_id')->references('id')->on('payment_system');
            $table->foreign('currency_id')->references('id')->on('currency');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direction', function (Blueprint $table) {
            $table->dropForeign(['payment_system_id']);
            $table->dropForeign(['currency_id']);

            $table->dropForeign(['created_user_id']);
            $table->dropForeign(['updated_user_id']);
            $table->dropForeign(['deleted_user_id']);
        });

        Schema::rename('direction', 'ps_currencies');

        Schema::table('ps_currencies', function (Blueprint $table) {
            $table->foreign('payment_system_id')->references('id')->on('payment_system');
            $table->foreign('currency_id')->references('id')->on('currency');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }
}
