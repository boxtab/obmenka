<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropColumnOnTableBid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('bid', 'box_id')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropForeign(['box_id']);
                $table->dropColumn('box_id');
            });
        }

        if (Schema::hasColumn('bid', 'client_wallet')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('client_wallet');
            });
        }

        if (Schema::hasColumn('bid', 'amount_enter')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('amount_enter');
            });
        }

        if (Schema::hasColumn('bid', 'amount_exit')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('amount_exit');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('box_id')
                ->after('exchange_direction_id')
                ->comment('Бокс');

            $table->string('client_wallet', 255)
                ->after('box_id')
                ->comment('Карта/кошелек клиента');

            $table->decimal('amount_enter', 18, 8)
                ->after('client_wallet')
                ->comment('Сумма на вход');

            $table->decimal('amount_exit', 18, 8)
                ->after('amount_enter')
                ->comment('Сумма на выход');

            $table->foreign('box_id')->references('id')->on('box');
        });
    }
}
