<?php

use App\Traits\MigrateHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableBoxBalance extends Migration
{
//    use MigrateHelper;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_balance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('box_id')->comment('Ссылка на бокс');

            $table->dateTime('shift_start')->nullable()->comment('Начало смены');
            $table->decimal('balance_start', 18,8)->nullable()->comment('Остаток на начало смены');

            $table->dateTime('shift_end')->nullable()->comment('Конец смены');
            $table->decimal('balance_end', 18,8)->nullable()->comment('Остаток на конец смены');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('box_id')->references('id')->on('box');
        });

        DB::statement("ALTER TABLE box_balance comment 'Остатки на боксах'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('box_balance');
    }
}
