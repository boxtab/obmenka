<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box', function (Blueprint $table) {
            $table->id();
            $table->enum('type_box', ['card', 'wallet'])->comment('Карта/кошелек');
            $table->string('unique_name', 128)->comment('Уникальный номер');
            $table->unsignedBigInteger('payment_system_id')->comment('Платежная система');
            $table->unsignedBigInteger('currency_id')->comment('Валюта');
            $table->timestamps();

            $table->unique('unique_name');

            $table->foreign('payment_system_id')->references('id')->on('payment_system');
            $table->foreign('currency_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('box');
    }
}
