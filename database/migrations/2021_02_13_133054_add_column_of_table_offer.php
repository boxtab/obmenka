<?php

use App\Models\Offer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOfTableOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer', function (Blueprint $table) {

            if (
                ! Schema::hasColumn('offer', 'enum_inc_exp') &&
                ! Schema::hasColumn('offer', 'box_id') &&
                ! Schema::hasColumn('offer', 'amount')
            ) {
                Offer::on()->truncate();
            }

            $table->enum('enum_inc_exp', ['inc', 'exp'])
                ->after('bid_id')
                ->comment('Приход/Расход');

            $table->unsignedBigInteger('box_id')
                ->after('enum_inc_exp')
                ->comment('Бокс');

            $table->decimal('amount', 18, 8)
                ->after('box_id')
                ->comment('Сумма');

            $table->foreign('box_id')->references('id')->on('box');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer', function (Blueprint $table) {
            $table->dropForeign('offer_box_id_foreign');
        });

        if (Schema::hasColumn('offer', 'amount')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('amount');
            });
        }

        if (Schema::hasColumn('offer', 'box_id')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('box_id');
            });
        }

        if (Schema::hasColumn('offer', 'enum_inc_exp')) {
            Schema::table('offer', function (Blueprint $table) {
                $table->dropColumn('enum_inc_exp');
            });
        }
    }
}
