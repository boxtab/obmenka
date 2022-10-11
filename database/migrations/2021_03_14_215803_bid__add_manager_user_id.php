<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddManagerUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_user_id')
                ->after('direction_give_id')
                ->nullable()
                ->comment('Менеджер. Второй сотрудник.');

            $table->foreign('manager_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['manager_user_id']);
            Schema::enableForeignKeyConstraints();
        });

        if ( Schema::hasColumn('bid', 'manager_user_id') ) {
            Schema::table('bid', function (Blueprint $table) {
                $table->dropColumn('manager_user_id');
            });
        }
    }
}
