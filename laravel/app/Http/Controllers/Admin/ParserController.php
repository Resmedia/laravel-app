<?php

namespace App\Http\Controllers\Admin;
use App\Jobs\ResourceParser;
use App\Resource;

/**
 * Created by PhpStorm.
 * User: rogozhuk
 * Date: 18.02.20
 * Time: 13:26
 */

class ParserController extends Controller
{
    public function index()
    {
        $rssAll = Resource::all();

        foreach ($rssAll as $rss) {
            ResourceParser::dispatch($rss->url);
        }

        return redirect('/admin/news')->with('success', "Новости успешно добавлены!");
    }
}