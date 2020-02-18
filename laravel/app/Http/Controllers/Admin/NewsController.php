<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        dump($request);

        return view('admin.news.index');
    }

    public function update(Request $request, $id = null)
    {
        if(!$id) {
            $model = new News();
        } else {
            $model = News::findOrFail($id);
        }

        return view('admin.news.update', [
            'model' => $model
        ]);
    }
}
