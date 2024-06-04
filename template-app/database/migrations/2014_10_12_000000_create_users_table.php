<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc');
            $table->string('filename');
            $table->string('params');
            $table->integer('user_id');
            $table->timestamps();
        });
        Schema::create('Static_Files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc');
            $table->string('filename');
            $table->longText('params');
        });
        DB::table('Static_Files')->insert(
            array(
                'title' => 'Commercial offer',
                'desc' => 'Template for a commertial offer given by an entrepreneur',
                'filename' => '0d74cf3cbe31d6b4.docx',
                'params' => '["Повне найменування ФОПу","Код ЄДРПОУ","Платник ПДВ","Дата створення","КВЕД","Адреса юридична","Адреса фактична","Контакти: телефон, ел. Пошта","ПІБ та посада керівника організації","ПІБ та посада контактної особи","Контакти контактної особи","Досвід (років)","Опис послуги що надаються замовнику","Назва послуги","Сума послуги в ГРН","Умови оплати пропозиції (безготівково чи готівково, дані рахунку, уточнити про наявність чи відсутність етапів розрахунку тощо)","Дата","ПІБ, посада"]',
        ));
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('files');
    }
};
