<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BoxBalanceAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('box_balance')->truncate();

        Schema::table('box_balance', function (Blueprint $table) {
            $table->date('balance_date')
                ->after('id')
                ->comment('Дата остатка');
        });

        Schema::table('box_balance', function (Blueprint $table) {
            $table->decimal('balance_amount', 18, 8)
                ->after('box_id')
                ->comment('Сумма остатка');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('box_balance', 'balance_date')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('balance_date');
            });
        }

        if (Schema::hasColumn('box_balance', 'balance_amount')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('balance_amount');
            });
        }
    }
}
