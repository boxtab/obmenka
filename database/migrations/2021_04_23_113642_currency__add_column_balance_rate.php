<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CurrencyAddColumnBalanceRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currency', function (Blueprint $table) {
            $table->decimal('balance', 18, 8)
                ->after('descr')
                ->default(0)
                ->comment('Начальный остаток валюты');
        });

        Schema::table('currency', function (Blueprint $table) {
            $table->decimal('rate', 18, 8)
                ->after('balance')
                ->default(0)
                ->comment('Курс валюты к рублю');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('currency', 'balance') ) {
            Schema::table('currency', function (Blueprint $table) {
                $table->dropColumn('balance');
            });
        }

        if ( Schema::hasColumn('currency', 'rate') ) {
            Schema::table('currency', function (Blueprint $table) {
                $table->dropColumn('rate');
            });
        }
    }
}
