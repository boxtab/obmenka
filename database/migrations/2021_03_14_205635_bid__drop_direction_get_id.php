<?php

use App\Models\Bid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidDropDirectionGetId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            Bid::on()->update( [ 'direction_get_id' => null ] );
            Schema::disableForeignKeyConstraints();
            $table->dropForeign( ['direction_get_id'] );
            $table->dropColumn('direction_get_id');
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
            $table->unsignedBigInteger('direction_get_id')
                ->comment('Направление. Что получаем.')
                ->nullable()
                ->after('deleted_user_id');

            $table->foreign('direction_get_id')->references('id')->on('direction');
        });
    }
}
