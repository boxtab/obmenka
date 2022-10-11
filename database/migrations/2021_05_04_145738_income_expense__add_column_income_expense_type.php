<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseAddColumnIncomeExpenseType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->unsignedBigInteger('income_expense_type_id')
                ->after('income_expense')
                ->nullable()
                ->index()
                ->comment('Ссылка на тип прихода/расхода');

            $table->foreign('income_expense_type_id')->references('id')->on('income_expense_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('income_expense', 'income_expense_type_id') ) {
            Schema::table('income_expense', function (Blueprint $table) {
                $table->dropForeign( ['income_expense_type_id'] );
                $table->dropColumn('income_expense_type_id');
            });
        }
    }
}
