<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TopDestinationsGroupAddMonthYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_destinations_group', function (Blueprint $table) {
            $table->decimal('month_year', 18, 8)
                ->after('description')
                ->comment('Месяц год.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('top_destinations_group', 'month_year') ) {
            Schema::table('top_destinations_group', function (Blueprint $table) {
                $table->dropColumn('month_year');
            });
        }
    }
}
