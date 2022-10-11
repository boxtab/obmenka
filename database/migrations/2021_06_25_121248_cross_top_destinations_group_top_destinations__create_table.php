<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrossTopDestinationsGroupTopDestinationsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_destinations_group_cross', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('top_destinations_id')->comment('Ссылка на источник дохода');
            $table->unsignedBigInteger('top_destinations_group_id')->comment('Ссылка на группы источников дохода');
            $table->timestamps();

            $table->foreign('top_destinations_id')->references('id')->on('top_destinations');
            $table->foreign('top_destinations_group_id')->references('id')->on('top_destinations_group');

            $table->unique(['top_destinations_id', 'top_destinations_group_id'], 'top_destinations_group_cross_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_destinations_group_cross');
    }
}
