<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceLeftAndRightFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            if (Schema::hasColumn('bid', 'exchange_direction_id')) {
                $table->dropForeign(['exchange_direction_id']);
                $table->dropColumn('exchange_direction_id');
            }

            $table->unsignedBigInteger('pscurrencies_get_id')->nullable()->comment('Валюта "Получаем"');
            $table->unsignedBigInteger('pscurrencies_give_id')->nullable()->comment('Валюта "Отдаем"');

            $table->foreign('pscurrencies_get_id')->references('id')->on('ps_currencies');
            $table->foreign('pscurrencies_give_id')->references('id')->on('ps_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('exchange_direction_id')->comment('Направление обмена');
            $table->foreign('exchange_direction_id')->references('id')->on('exchange_direction');

            if (Schema::hasColumn('bid', 'pscurrencies_get_id')) {
                $table->dropForeign(['pscurrencies_get_id']);
                $table->dropColumn('pscurrencies_get_id');
            }

            if (Schema::hasColumn('bid', 'pscurrencies_give_id')) {
                $table->dropForeign(['pscurrencies_give_id']);
                $table->dropColumn('pscurrencies_give_id');
            }
        });
    }
}
