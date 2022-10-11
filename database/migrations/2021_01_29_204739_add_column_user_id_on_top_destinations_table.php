<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserIdOnTopDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_destinations', function (Blueprint $table) {
            $table->unsignedBigInteger('created_user_id')
                ->after('deleted_at')
                ->nullable()
                ->comment('Кто создал запись');

            $table->unsignedBigInteger('updated_user_id')
                ->after('created_user_id')
                ->nullable()
                ->comment('Кто последний изменил запись');

            $table->unsignedBigInteger('deleted_user_id')
                ->after('updated_user_id')
                ->nullable()
                ->comment('Кто удалил запись');

            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('deleted_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_destinations', function (Blueprint $table) {
            $table->dropForeign('top_destinations_created_user_id_foreign');
        });

        Schema::table('top_destinations', function (Blueprint $table) {
            $table->dropForeign('top_destinations_updated_user_id_foreign');
        });

        Schema::table('top_destinations', function (Blueprint $table) {
            $table->dropForeign('top_destinations_deleted_user_id_foreign');
        });

        if (Schema::hasColumn('top_destinations', 'created_user_id')) {
            Schema::table('top_destinations', function (Blueprint $table) {
                $table->dropColumn('created_user_id');
            });
        }

        if (Schema::hasColumn('top_destinations', 'updated_user_id')) {
            Schema::table('top_destinations', function (Blueprint $table) {
                $table->dropColumn('updated_user_id');
            });
        }

        if (Schema::hasColumn('top_destinations', 'deleted_user_id')) {
            Schema::table('top_destinations', function (Blueprint $table) {
                $table->dropColumn('deleted_user_id');
            });
        }
    }
}
