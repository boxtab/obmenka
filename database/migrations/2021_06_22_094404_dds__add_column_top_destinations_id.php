<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DdsAddColumnTopDestinationsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds', function (Blueprint $table) {
            $table->unsignedBigInteger('top_destinations_id')
                ->after('descr')
                ->nullable()
                ->comment('Ссылка на топ направлений.');

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
        if (Schema::hasColumn('dds', 'top_destinations_id')) {
            Schema::table('dds', function (Blueprint $table) {
                $table->dropForeign( ['top_destinations_id'] );
                $table->dropColumn('top_destinations_id');
            });
        }
    }
}
