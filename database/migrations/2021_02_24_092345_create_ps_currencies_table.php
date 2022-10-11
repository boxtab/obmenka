<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps_currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_system_id')->nullable()->comment('Пплатежная система');
            $table->unsignedBigInteger('currency_id')->nullable()->comment('Код валюты');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['payment_system_id', 'currency_id',], 'ps_currencies_all_column');

            $table->foreign('payment_system_id')->references('id')->on('payment_system');
            $table->foreign('currency_id')->references('id')->on('currency');

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
        Schema::dropIfExists('ps_currencies');
    }
}
