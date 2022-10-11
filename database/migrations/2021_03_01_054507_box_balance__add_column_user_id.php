<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxBalanceAddColumnUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box_balance', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')
                ->after('id')
                ->comment('Чья смена');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('box_balance', function (Blueprint $table) {
            Schema::table('box_balance', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        });
    }
}
