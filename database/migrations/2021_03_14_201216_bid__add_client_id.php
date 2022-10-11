<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasColumn('bid', 'client_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')
                    ->after('top_destinations_id')
                    ->nullable()
                    ->comment('Клиент');

                $table->foreign('client_id')->references('id')->on('client');
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
        Schema::table('bid', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['client_id']);
            Schema::enableForeignKeyConstraints();
        });

        if ( Schema::hasColumn('bid', 'client_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('client_id');
            });
        }
    }
}
