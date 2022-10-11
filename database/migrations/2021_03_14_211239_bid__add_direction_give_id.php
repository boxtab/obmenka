<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddDirectionGiveId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('direction_give_id')
                ->after('direction_get_id')
                ->nullable()
                ->comment('Направление. Что отдаем.');

            $table->foreign('direction_give_id')->references('id')->on('direction');
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
            $table->dropForeign(['direction_give_id']);
            Schema::enableForeignKeyConstraints();
        });

        if ( Schema::hasColumn('bid', 'direction_give_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('direction_give_id');
            });
        }
    }
}
