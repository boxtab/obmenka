<?php

use App\Models\Bid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidDropBidNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            Bid::on()->update( [ 'bid_number' => null ] );
            $table->dropColumn('bid_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('bid_number')
                ->after('deleted_user_id')
                ->nullable()
                ->index()
                ->comment('Номер заявки');
        });
    }
}
