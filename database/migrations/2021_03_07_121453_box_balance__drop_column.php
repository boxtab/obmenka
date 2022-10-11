<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxBalanceDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('box_balance', 'user_id')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropForeign('box_balance_user_id_foreign');
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('box_balance', 'shift_start')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('shift_start');
            });
        }

        if (Schema::hasColumn('box_balance', 'balance_start')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('balance_start');
            });
        }

        if (Schema::hasColumn('box_balance', 'shift_end')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('shift_end');
            });
        }

        if (Schema::hasColumn('box_balance', 'balance_end')) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('balance_end');
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
        Schema::table('box_balance', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->after('id')
                ->comment('Чья смена');
            $table->foreign('user_id')->references('id')->on('users');

            $table->dateTime('shift_start')
                ->after('box_id')
                ->nullable()
                ->comment('Начало смены');

            $table->decimal('balance_start', 18,8)
                ->after('shift_start')
                ->nullable()
                ->comment('Остаток на начало смены');

            $table->dateTime('shift_end')
                ->after('balance_start')
                ->nullable()
                ->comment('Конец смены');

            $table->decimal('balance_end', 18,8)
                ->after('shift_end')
                ->nullable()
                ->comment('Остаток на конец смены');
        });
    }
}
