<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->comment('Полное имя клиента');
            $table->string('email')->nullable()->comment('Email клиента');
            $table->string('phone', 18)->nullable()->comment('Телефон клиента');
            $table->string('note')->nullable()->comment('Заметка');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_user_id')->nullable()->comment('Кто создал запись');
            $table->unsignedBigInteger('updated_user_id')->nullable()->comment('Кто последний изменил запись');
            $table->unsignedBigInteger('deleted_user_id')->nullable()->comment('Кто удалил запись');

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
        Schema::dropIfExists('clients');
    }
}
