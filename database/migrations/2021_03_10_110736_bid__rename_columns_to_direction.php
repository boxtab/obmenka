<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidRenameColumnsToDirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            if (Schema::hasColumn('bid', 'pscurrencies_get_id')) {
                $table->dropForeign(['pscurrencies_get_id']);
            }

            if (Schema::hasColumn('bid', 'pscurrencies_give_id')) {
                $table->dropForeign(['pscurrencies_give_id']);
            }

            $table->renameColumn('pscurrencies_get_id', 'direction_get_id');
            $table->renameColumn('pscurrencies_give_id', 'direction_give_id');

            $table->foreign('direction_get_id')->references('id')->on('direction');
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
            if (Schema::hasColumn('bid', 'direction_get_id')) {
                $table->dropForeign(['direction_get_id']);
            }

            if (Schema::hasColumn('bid', 'direction_give_id')) {
                $table->dropForeign(['direction_give_id']);
            }

            $table->renameColumn('direction_get_id', 'pscurrencies_get_id');
            $table->renameColumn('direction_give_id', 'pscurrencies_give_id');

            $table->foreign('pscurrencies_get_id')->references('id')->on('ps_currencies');
            $table->foreign('pscurrencies_give_id')->references('id')->on('ps_currencies');
        });
    }
}
