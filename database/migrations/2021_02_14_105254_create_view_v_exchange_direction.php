<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewVExchangeDirection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "create or replace view v_exchange_direction as ";
        $query .= "select
                           ed.id,
                           ed.left_payment_system_id,
                           lps.descr as left_payment_system_descr,
                           ed.left_currency_id,
                           lc.descr as left_currency_descr,
                           ed.right_payment_system_id,
                           rps.descr as right_payment_system_descr,
                           ed.right_currency_id,
                           rc.descr as right_currency_descr
                    from exchange_direction as ed
                        left outer join payment_system as lps on ed.left_payment_system_id = lps.id
                        left outer join currency as lc on ed.left_currency_id = lc.id
                        left outer join payment_system as rps on right_payment_system_id = rps.id
                        left outer join currency as rc on right_currency_id = rc.id
                    ;";
        DB::statement( $query );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS v_exchange_direction");
    }
}
