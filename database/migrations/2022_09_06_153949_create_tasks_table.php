<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // обязательное. Название задачи
            $table->text('description')->nullable(); // - необязательное. Описание задачи
            $table->bigInteger('status_id');// - обязательное. Связано с сущностью статуса
            $table->bigInteger('created_by_id');// - обязательное. Связано с сущностью пользователя. Создатель задачи
            $table->bigInteger('assigned_to_id')->nullable();// - необязательное. Связано с сущностью пользователя. Тот на кого поставлена задача
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
