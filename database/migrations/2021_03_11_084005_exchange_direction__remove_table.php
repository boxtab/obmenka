<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ExchangeDirectionRemoveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('exchange_direction');
        DB::statement("DROP VIEW IF EXISTS v_exchange_direction");
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('exchange_direction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('left_payment_system_id')->comment('Левая платежная система');
            $table->unsignedBigInteger('left_currency_id')->comment('Левая валюта');
            $table->unsignedBigInteger('right_payment_system_id')->comment('Правая платежная система');
            $table->unsignedBigInteger('right_currency_id')->comment('Правая валюта');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_user_id')->nullable()->comment('Кто создал запись');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('Кто последний изменил запись');
            $table->unsignedBigInteger('deleted_user_id')->nullable()->comment('Кто удалил запись');

            $table->unique([
                'left_payment_system_id',
                'left_currency_id',
                'right_payment_system_id',
                'right_currency_id'
            ], 'exchange_direction_all_column');

            $table->foreign('left_payment_system_id')->references('id')->on('payment_system');
            $table->foreign('left_currency_id')->references('id')->on('currency');
            $table->foreign('right_payment_system_id')->references('id')->on('payment_system');
            $table->foreign('right_currency_id')->references('id')->on('currency');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });

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
        DB::statement($query);
    }
}
