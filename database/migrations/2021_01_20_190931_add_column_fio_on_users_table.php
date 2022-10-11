<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFioOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname', 255)
                ->after('id')
                ->nullable()
                ->comment('Фамилия');

            $table->string('patronymic', 255)
                ->after('name')
                ->nullable()
                ->comment('Отчество');

            $table->date('birthday')
                ->after('patronymic')
                ->nullable()
                ->comment('Дата рождения');

            $table->unsignedBigInteger('role_id')
                ->after('remember_token')
                ->nullable()
                ->comment('Роль');

            $table->enum('work', ['yes', 'no'])
                ->after('remember_token')
                ->nullable()
                ->comment('Да/Нет - Работает/не работает');

            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
        });

        if (Schema::hasColumn('users', 'surname')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('surname');
            });
        }
    }
}
