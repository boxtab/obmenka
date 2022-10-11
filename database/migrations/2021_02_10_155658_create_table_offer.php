<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bid_id')->comment('Заявки');

            $table->unsignedBigInteger('left_box_id')->comment('Левый бокс');
            $table->string('left_wallet', 255)->comment('Левая карта/кошелек клиента');
            $table->decimal('left_amount', 18,8)->comment('Сумма на вход');

            $table->unsignedBigInteger('right_box_id')->comment('Правый бокс');
            $table->string('right_wallet', 255)->comment('Правая карта/кошелек клиента');
            $table->decimal('right_amount', 18,8)->comment('Сумма на выход');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bid_id')->references('id')->on('bid');
            $table->foreign('left_box_id')->references('id')->on('box');
            $table->foreign('right_box_id')->references('id')->on('box');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer');
    }
}
