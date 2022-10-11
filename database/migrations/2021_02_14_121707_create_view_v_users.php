<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewVUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "create or replace view v_users as ";
        $query .= "select u.id,
                           u.surname,
                           u.name,
                           u.patronymic,
                           u.birthday,
                           u.email,
                           u.work,
                           if (u.work = 'yes', 'Да', 'Нет') as work_descr,
                           u.role_id,
                           r.descr,
                           concat(u.surname, ' ', left(u.name, 1), '. ', left(u.patronymic, 1), '.') as fio
                    from users as u left outer join role as r on u.role_id = r.id
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
