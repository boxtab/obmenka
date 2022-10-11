<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseAddForeignKeyBoxId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->foreign('box_id')->references('id')->on('box');
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
            $table->dropForeign( ['box_id'] );
        });
    }
}
