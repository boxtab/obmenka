<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseDdsIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->unsignedBigInteger('dds_id')
                ->comment('Код ДДС')
                ->nullable()
                ->change();
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
            $table->unsignedBigInteger('dds_id')
                ->comment('Код ДДС')
                ->change();
        });
    }
}
