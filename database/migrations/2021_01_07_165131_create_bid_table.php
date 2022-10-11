<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('exchange_direction_id')->comment('Направление обмена');
            $table->unsignedBigInteger('box_id')->comment('Бокс');
            $table->string('client_wallet', 255)->comment('Карта/кошелек клиента');
            $table->decimal('amount_enter', 18,8)->comment('Сумма на вход');
            $table->decimal('amount_exit', 18,8)->comment('Сумма на выход');
            $table->string('note', 512)->nullable()->comment('Комментарий');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exchange_direction_id')->references('id')->on('exchange_direction');
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
        Schema::dropIfExists('bid');
    }
}
