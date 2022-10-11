<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeDirectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_direction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('left_payment_system_id')->comment('Левая платежная система');
            $table->unsignedBigInteger('left_currency_id')->comment('Левая валюта');
            $table->unsignedBigInteger('right_payment_system_id')->comment('Правая платежная система');
            $table->unsignedBigInteger('right_currency_id')->comment('Правая валюта');
            $table->timestamps();

            $table->unique([
                'left_payment_system_id',
                'left_currency_id',
                'right_payment_system_id',
                'right_currency_id'
            ], 'exchange_direction_all_column');

            $table->foreign('left_payment_system_id')->references('id')->on('payment_system');
            $table->foreign('left_currency_id')->references('id')->on('currency');
            $table->foreign('right_payment_system_id')->references('id')->on('payment_system');
            $table->foreign('right_currency_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_direction');
    }
}
