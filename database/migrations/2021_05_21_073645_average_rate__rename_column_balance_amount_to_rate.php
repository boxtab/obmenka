<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AverageRateRenameColumnBalanceAmountToRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('average_rate', function (Blueprint $table) {
            $table->renameColumn( 'balance_amount', 'rate' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('average_rate', function (Blueprint $table) {
            $table->renameColumn( 'rate', 'balance_amount' );
        });
    }
}
