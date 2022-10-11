<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddBidNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('bid_number')
                ->after('id')
                ->nullable()
                ->index()
                ->comment('Номер заявки');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('bid', 'bid_number') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('bid_number');
            });
        }
    }
}
