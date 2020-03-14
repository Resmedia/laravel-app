<?php

namespace App\Services;

use ACFBentveld\XML\XML;
use App\Category;
use App\News;
use URLify;

/**
 * Created by PhpStorm.
 * User: rogozhuk
 * Date: 14.03.20
 * Time: 17:50
 */

class XMLParseService
{
    public function saveNews($url)
    {
        $xml = XML::import($url)->raw();

        foreach($xml as $channels) {
            /** @var $new XML */
            $channel = (object)$channels;

            foreach ($channel->item as $item) {
                $exist = News::where('title', $item->title)->first();

                $category = Category::where('name', $item->category)->first();
                $savedCategory = 7;

                if(empty($category) && !empty($item->category)){
                    $category = new Category();
                    $category->name = $item->category;
                    $category->save();
                } elseif (empty($category) && empty($item->category)) {
                    $category = [];
                }

                if(empty($exist)) {
                    $news = new News();
                    $news->fill([
                        'author_id' => 1,
                        'title' => $item->title ?: '',
                        'image' => $item->image ?: '',
                        'content' => $item->description,
                        'slug' => $item->title ? URLify::filter($item->title, 120, "en", true) : '',
                        'category_id' => !empty($category) ? $category->id : $savedCategory,
                    ]);

                    if(!$news->save()) {
                        return redirect('/admin/news')->with('error', 'Ошибка сохранения!');
                    }
                }
            }
        }

        return true;
    }
}