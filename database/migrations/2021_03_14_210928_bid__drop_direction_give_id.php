<?php

use App\Models\Bid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidDropDirectionGiveId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            Bid::on()->update( [ 'direction_give_id' => null ] );
            Schema::disableForeignKeyConstraints();
            $table->dropForeign( ['direction_give_id'] );
            $table->dropColumn('direction_give_id');
            Schema::enableForeignKeyConstraints();
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
            $table->unsignedBigInteger('direction_give_id')
                ->comment('Направление. Что отдаем.')
                ->nullable()
                ->after('deleted_user_id');

            $table->foreign('direction_give_id')->references('id')->on('direction');
        });
    }
}
