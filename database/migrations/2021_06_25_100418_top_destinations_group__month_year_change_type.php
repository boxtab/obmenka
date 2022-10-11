<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TopDestinationsGroupMonthYearChangeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_destinations_group', function (Blueprint $table) {
            $table->date('month_year')
                ->after('description')
                ->comment('Месяц год.')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_destinations_group', function (Blueprint $table) {
            $table->decimal('month_year', 18, 8)
                ->after('description')
                ->comment('Месяц год.')
                ->change();
        });
    }
}
