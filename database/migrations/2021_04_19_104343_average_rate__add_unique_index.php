<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AverageRateAddUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('average_rate', function (Blueprint $table) {
            $table->unique( ['rate_date', 'currency_id'] );
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
            $table->dropUnique('average_rate_rate_date_currency_id_unique');
        });
    }
}
