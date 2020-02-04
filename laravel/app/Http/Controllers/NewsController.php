<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request): View
    {
        $news = News::search($request->input('q'))
            ->latest()
            ->paginate(20);

        return view('news.index', [
            'news' => $news
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
