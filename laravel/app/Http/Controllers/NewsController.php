<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request, $id = null): View
    {
        $images = [];

        $news = News::search($request->input('q'))
            ->latest()
            ->paginate(20);

        $categories = Category::all();

        $category = $id ? Category::findOrFail($id) : null;

        if ($id && $request->is('news/category/'. $id)) {
            $news = News::where(['category_id' => $id])
                ->latest()
                ->paginate(20);
        }

        return view('news.index', [
            'news' => $news,
            'images' => $images,
            'category' => $category,
            'categories' => $categories
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $images = Storage::files("/news/$id") ?: null;
        return view('news.show', [
            'images' => $images,
            'news' => News::findOrFail($id)]
        );
    }
}
