<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxBalanceAddUniqueKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box_balance', function (Blueprint $table) {
            $table->unique(['balance_date', 'box_id']);
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
            $table->dropUnique('box_balance_balance_date_box_id_unique');
        });
    }
}
