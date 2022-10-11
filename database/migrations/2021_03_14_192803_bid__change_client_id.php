<?php

use App\Models\Bid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidChangeClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            Bid::on()->update( [ 'client_id' => null ] );
            Schema::disableForeignKeyConstraints();
            $table->dropForeign( ['client_id'] );
            $table->dropColumn('client_id');
            Schema::enableForeignKeyConstraints();
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
            $table->unsignedBigInteger('client_id')
                ->comment('Клиент')
                ->nullable()
                ->after('second_employee');

            $table->foreign('client_id')->references('id')->on('client');
        });
    }
}
