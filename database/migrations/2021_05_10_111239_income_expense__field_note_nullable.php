<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseFieldNoteNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->string('note', 1024)
                ->comment('Комментарий')
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
            $table->string('note', 1024)
                ->comment('Комментарий')
                ->change();
        });
    }
}
