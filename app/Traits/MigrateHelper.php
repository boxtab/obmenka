<?php

namespace App\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait MigrateHelper
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

