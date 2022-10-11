<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TopDestinationsGroupCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'top_destinations_group';

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('description', 32)->unique()->comment('Название группы источников дохода');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE ' . $tableName . ' COMMENT '. ' "Группы источников дохода";');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_destinations_group');
    }
}
