<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\News', 30)->create();

        DB::update('UPDATE `news` SET `category_id` = FLOOR(RAND()*6)+1');
    }
}
