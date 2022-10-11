<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'offer', function(Blueprint $table)
        {
            $table->dropForeign('offer_left_box_id_foreign');
            $table->dropForeign('offer_right_box_id_foreign');
        });

        if (Schema::hasColumn('offer', 'left_box_id')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('left_box_id');
            });
        }

        if (Schema::hasColumn('offer', 'left_wallet')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('left_wallet');
            });
        }

        if (Schema::hasColumn('offer', 'left_amount')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('left_amount');
            });
        }


        if (Schema::hasColumn('offer', 'right_box_id')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('right_box_id');
            });
        }

        if (Schema::hasColumn('offer', 'right_wallet')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('right_wallet');
            });
        }

        if (Schema::hasColumn('offer', 'right_amount')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('right_amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer', function (Blueprint $table) {
            $table->unsignedBigInteger('left_box_id')
                ->after('box_id')
                ->comment('Левый бокс');

            $table->string('left_wallet', 255)
                ->after('left_box_id')
                ->comment('Левый кошелек клиента');

            $table->decimal('left_amount', 18, 8)
                ->after('left_wallet')
                ->comment('Левый сумма');


            $table->unsignedBigInteger('right_box_id')
                ->after('left_amount')
                ->comment('Правый бокс');

            $table->string('right_wallet', 255)
                ->after('right_box_id')
                ->comment('Правый кошелек клиента');

            $table->decimal('right_amount', 18, 8)
                ->after('right_wallet')
                ->comment('Правая сумма');

            $table->foreign('left_box_id')->references('id')->on('box');
            $table->foreign('right_box_id')->references('id')->on('box');
        });
    }
}
