<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TopDestinationsGroupDescriptionMonthYearUniqueKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_destinations_group', function (Blueprint $table) {
            $table->unique(['description', 'month_year'], 'top_destinations_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('top_destinations_group_cross', function (Blueprint $table) {
            $table->dropUnique('top_destinations_group_unique');
        });
    }
}
