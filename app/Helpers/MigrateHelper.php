<?php

namespace App\Helpers;

use Illuminate\Database\Schema\Blueprint;

class MigrateHelper
{
    public static function addTehColumn( Blueprint $table )
    {
        $table->unsignedBigInteger('created_user_id')
            ->nullable()
            ->comment('Кто создал запись');

        $table->unsignedBigInteger('updated_user_id')
            ->nullable()
            ->comment('Кто последний изменил запись');

        $table->unsignedBigInteger('deleted_user_id')
            ->after('updated_user_id')
            ->nullable()
            ->comment('Кто удалил запись');
    }

    public static function addForeignKeyTehColumn( Blueprint $table )
    {
        $table->foreign('created_user_id')->references('id')->on('users');
        $table->foreign('updated_user_id')->references('id')->on('users');
        $table->foreign('deleted_user_id')->references('id')->on('users');
    }
}
