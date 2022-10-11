<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_expense_type', function (Blueprint $table) {
            $table->id();
            $table->string('description')->comment('Типы прихода/расхода');
            $table->timestamps();

            $table->unsignedBigInteger('created_user_id')->nullable()->comment('Кто создал запись');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('Кто последний изменил запись');
            $table->unsignedBigInteger('deleted_user_id')->nullable()->comment('Кто удалил запись');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_expense_type');
    }
}
