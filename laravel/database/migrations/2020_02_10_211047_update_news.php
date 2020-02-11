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
            $table->integer('category_id');
        });

        DB::insert('insert into `categories` (`name`) values ("Политика"), ("Спорт"), ("Юмор"), ("Экономика"), ("Мир"), ("Строительство")');
        DB::update('UPDATE `news` SET `category_id` = FLOOR(RAND()*6)+1;');
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
