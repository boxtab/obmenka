<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseFieldPrecision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->decimal('amount', 22, 12)->change();
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
            $table->decimal('amount', 18, 8)->change();
        });
    }
}
