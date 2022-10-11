<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BoxAddColumnPscurrencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('box')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            if (Schema::hasColumn('box', 'payment_system_id')) {
                $table->dropForeign(['payment_system_id']);
                $table->dropColumn('payment_system_id');
            }

            if (Schema::hasColumn('box', 'currency_id')) {
                $table->dropForeign(['currency_id']);
                $table->dropColumn('currency_id');
            }

            if (!Schema::hasColumn('box', 'pscurrencies_id')) {
                $table->unsignedBigInteger('pscurrencies_id')->comment('Направление');
                $table->foreign('pscurrencies_id')->references('id')->on('ps_currencies');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('box')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            if (Schema::hasColumn('box', 'pscurrencies_id')) {
                $table->dropForeign(['pscurrencies_id']);
                $table->dropColumn('pscurrencies_id');
            }

            if (!Schema::hasColumn('box', 'payment_system_id')) {
                $table->unsignedBigInteger('payment_system_id')->comment('Платежная система');
                $table->foreign('payment_system_id')->references('id')->on('payment_system');
            }

            if (!Schema::hasColumn('box', 'currency_id')) {
                $table->unsignedBigInteger('currency_id')->comment('Валюта');
                $table->foreign('currency_id')->references('id')->on('currency');
            }
        });
    }
}
