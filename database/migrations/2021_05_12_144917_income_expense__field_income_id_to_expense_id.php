<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseFieldIncomeIdToExpenseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->renameColumn('income_id', 'expense_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->renameColumn('expense_id', 'income_id');
        });
    }
}
