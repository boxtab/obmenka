<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidRemoveClientColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            if (Schema::hasColumn('bid', 'client_fullname')) {
                $table->dropColumn('client_fullname');
            }

            if (Schema::hasColumn('bid', 'client_email')) {
                $table->dropColumn('client_email');
            }

            if (Schema::hasColumn('bid', 'client_phone')) {
                $table->dropColumn('client_phone');
            }
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
            if (!Schema::hasColumn('bid', 'client_fullname')) {
                $table->string('client_fullname')->default('')->comment('Полное имя клиента');
            }

            if (!Schema::hasColumn('bid', 'client_email')) {
                $table->string('client_email')->default('')->comment('Email клиента');
            }

            if (!Schema::hasColumn('bid', 'client_phone')) {
                $table->string('client_phone', 18)->default('')->comment('Телефон клиента');
            }
        });
    }
}
