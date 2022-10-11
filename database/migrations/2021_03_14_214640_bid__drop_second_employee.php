<?php

use App\Models\Bid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BidDropSecondEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid', function (Blueprint $table) {
            Bid::on()->update( [ 'second_employee' => null ] );
            Schema::disableForeignKeyConstraints();
            $table->dropForeign( ['second_employee'] );
            $table->dropColumn('second_employee');
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
            $table->unsignedBigInteger('second_employee')
                ->comment('Второй сотрудник')
                ->nullable()
                ->after('deleted_user_id');

            $table->foreign('second_employee')->references('id')->on('Users');
        });
    }
}
