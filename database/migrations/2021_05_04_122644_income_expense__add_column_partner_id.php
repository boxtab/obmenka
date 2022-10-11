<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncomeExpenseAddColumnPartnerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_expense', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_id')
                ->after('dds_id')
                ->nullable()
                ->index()
                ->comment('Ссылка на партнера');

            $table->foreign('partner_id')->references('id')->on('partners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( Schema::hasColumn('income_expense', 'partner_id') ) {
            Schema::table('income_expense', function (Blueprint $table) {
                $table->dropForeign( ['partner_id'] );
                $table->dropColumn('partner_id');
            });
        }
    }
}
