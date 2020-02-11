<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request, $id = null): View
    {

        $news = News::search($request->input('q'))
            ->latest()
            ->paginate(20);

        $categories = Category::all();

        if ($id && $request->is('news/category/'. $id)) {
            $news = News::where(['category_id' => $id])
                ->latest()
                ->paginate(20);
        }

        return view('news.index', [
            'news' => $news,
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('news.show', ['news' => News::findOrFail($id)]);
    }
}
