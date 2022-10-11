<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOfTopDestinationsIdOnTableBid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('exchange_direction_id')
                ->nullable()
                ->comment('Направление обмена')
                ->change();

            $table->unsignedBigInteger('top_destinations_id')
                ->after('exchange_direction_id')
                ->nullable()
                ->comment('Источники доходов');

            $table->foreign('top_destinations_id')->references('id')->on('top_destinations');
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
            $table->dropForeign('bid_top_destinations_id_foreign');
        });

        if (Schema::hasColumn('bid', 'top_destinations_id')) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('top_destinations_id');
            });
        }

        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('exchange_direction_id')
                ->comment('Направление обмена')
                ->change();
        });
    }
}
