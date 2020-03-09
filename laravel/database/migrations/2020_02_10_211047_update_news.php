<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 255);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->integer('category_id')->default(0);
        });

        DB::insert('
              INSERT INTO `categories` (`name`) 
              VALUES ("Политика"), ("Спорт"), ("Юмор"), ("Экономика"), ("Мир"), ("Строительство"), ("Парсер")
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
