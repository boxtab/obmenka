<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseAddColumnIncomeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->unsignedBigInteger('income_id')
                ->after('rate')
                ->nullable()
                ->index()
                ->comment('Ссылка на приход');

            $table->foreign('income_id')->references('id')->on('income_expense');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('income_expense', 'income_id') ) {
            Schema::table('income_expense', function (Blueprint $table) {
                $table->dropForeign( ['income_id'] );
                $table->dropColumn('income_id');
            });
        }
    }
}
