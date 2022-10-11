<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BoxAddColumnBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box', function (Blueprint $table) {
            $table->decimal('balance', 18, 8)
                ->after('unique_name')
                ->default(0)
                ->comment('Начальный остаток.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('box', 'balance') ) {
            Schema::table('box', function (Blueprint $table) {
                $table->dropColumn('balance');
            });
        }
    }
}
