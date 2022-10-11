<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_expense', function (Blueprint $table) {
            $table->id();
            $table->enum('income_expense', ['income', 'expense'])->comment('Приход или расход');
            $table->unsignedBigInteger('dds_id')->comment('Код ДДС. dds.id');
            $table->unsignedBigInteger('box_id')->comment('Код бокса. box.id');
            $table->decimal('amount', 18, 8)->comment('Сумма прихода или расхода');
            $table->decimal('rate', 18, 8)->comment('Курс к рублю');
            $table->string('note', 1024)->comment('Комментарий');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_expense');
    }
}
