<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            if (!Schema::hasColumn('bid', 'bid_number')) {
                $table->unsignedBigInteger('bid_number')->nullable()->index()->comment('Номер заявки');
            }

            if (!Schema::hasColumn('bid', 'client_fullname')) {
                $table->string('client_fullname')->default('')->comment('Полное имя клиента');
            }

            if (!Schema::hasColumn('bid', 'client_email')) {
                $table->string('client_email')->default('')->comment('Email клиента');
            }

            if (!Schema::hasColumn('bid', 'client_phone')) {
                $table->string('client_phone', 18)->default('')->comment('Телефон клиента');
            }

            if (!Schema::hasColumn('bid', 'second_employee')) {
                $table->unsignedBigInteger('second_employee')->nullable()->comment('Второй сотрудник');
                $table->foreign('second_employee')->references('id')->on('users');
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
            if (Schema::hasColumn('bid', 'bid_number')) {
                $table->dropColumn('bid_number');
            }

            if (Schema::hasColumn('bid', 'client_fullname')) {
                $table->dropColumn('client_fullname');
            }

            if (Schema::hasColumn('bid', 'client_email')) {
                $table->dropColumn('client_email');
            }

            if (Schema::hasColumn('bid', 'client_phone')) {
                $table->dropColumn('client_phone');
            }

            if (Schema::hasColumn('bid', 'second_employee')) {
                $table->dropForeign(['second_employee']);
                $table->dropColumn('second_employee');
            }
        });
    }
}
