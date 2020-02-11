<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'name' => 'Новости',
            'url' => 'news',
            'parent_id' => 0,
        ]);

        DB::table('menus')->insert([
            'name' => 'О проекте',
            'url' => 'about',
            'parent_id' => 0,
        ]);
    }
}
