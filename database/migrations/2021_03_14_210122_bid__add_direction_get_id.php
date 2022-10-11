<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddDirectionGetId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('direction_get_id')
                ->after('client_id')
                ->nullable()
                ->comment('Направление. Что получаем.');

            $table->foreign('direction_get_id')->references('id')->on('direction');
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
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['direction_get_id']);
            Schema::enableForeignKeyConstraints();
        });

        if ( Schema::hasColumn('bid', 'direction_get_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('direction_get_id');
            });
        }
    }
}
