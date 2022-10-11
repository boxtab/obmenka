<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExistingFieldToNullableOnTableOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer', function (Blueprint $table) {
            $table->string('left_wallet', 255)->nullable()->comment('Левая карта/кошелек клиента')->change();
            $table->string('right_wallet', 255)->nullable()->comment('Правая карта/кошелек клиента')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer', function (Blueprint $table) {
            $table->string('left_wallet', 255)->comment('Левая карта/кошелек клиента')->change();
            $table->string('right_wallet', 255)->comment('Правая карта/кошелек клиента')->change();
        });
    }
}
