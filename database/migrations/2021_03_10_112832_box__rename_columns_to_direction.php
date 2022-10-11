<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxRenameColumnsToDirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            if (Schema::hasColumn('box', 'pscurrencies_id')) {
                $table->dropForeign(['pscurrencies_id']);
            }

            $table->renameColumn('pscurrencies_id', 'direction_id');
            $table->foreign('direction_id')->references('id')->on('direction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('box', function (Blueprint $table) {
            if (Schema::hasColumn('box', 'direction_id')) {
                $table->dropForeign(['direction_id']);
            }

            $table->renameColumn('direction_id', 'pscurrencies_id');
            $table->foreign('pscurrencies_id')->references('id')->on('ps_currencies');
        });
    }
}
