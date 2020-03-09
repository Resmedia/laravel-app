<?php

namespace App\Http\Controllers\Admin;
use ACFBentveld\XML\XML;
use App\News;
use Illuminate\View\View;
use URLify;

/**
 * Created by PhpStorm.
 * User: rogozhuk
 * Date: 18.02.20
 * Time: 13:26
 */

class ParserController extends Controller
{
    private $rss = 'https://zsrf.ru/news/rss';

    public function index()
    {
        $xml = XML::import($this->rss)->raw();

        foreach($xml as $channels) {
            /** @var $new XML */
            $channel = (object)$channels;
            $i = 0;
            foreach ($channel->item as $item) {
                $exist = News::where('title', $item->title)->first();
                $news = new News();
                if(empty($exist)) {
                    $i++;
                    dump($exist);
                    $news->fill([
                        'author_id' => 1,
                        'title' => $item->title,
                        'content' => $item->description,
                        'slug' => URLify::filter($item->title, 120, "en", true),
                        'category_id' => 7,
                    ]);

                    if(!$news->save()) {
                        return redirect('/admin/news')->with('error', 'Ошибка сохранения!');
                    }
                }
            }

            return redirect('/admin/news')->with('success', $i > 0 ? "Добавлено успешно $i новостей!" : "Нет новых новостей!");
        }

        return false;
    }
}