<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidDropColumnExchangeDirectionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( Schema::hasColumn('bid', 'exchange_direction_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropForeign('bid_exchange_direction_id_foreign');
                $table->dropColumn('exchange_direction_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('bid', 'exchange_direction_id')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->unsignedBigInteger('exchange_direction_id')
                    ->after('bid_number')
                    ->comment('Направление обмена');
            });
        }
    }
}
