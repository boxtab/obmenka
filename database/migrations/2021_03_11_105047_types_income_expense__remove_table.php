<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypesIncomeExpenseRemoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('types_income_expense');
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('types_income_expense', function (Blueprint $table) {
            $table->id();
            $table->string('descr', 128)->unique()->comment('Виды прихода и расхода');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_user_id')->nullable()->comment('Кто создал запись');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('Кто последний изменил запись');
            $table->unsignedBigInteger('deleted_user_id')->nullable()->comment('Кто удалил запись');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }
}
