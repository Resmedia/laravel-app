<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $models = News::search($request->input('q'))
            ->latest()
            ->paginate(20);

        return view('admin.news.index', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' =>  'required',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        $news = new News($request->all());
        $news->author_id = Auth::id();
        $news->posted_at = date('Y-m-d H:i:s');
        $news->updated_at = date('Y-m-d H:i:s');
        $news->created_at = date('Y-m-d H:i:s');
        if($news->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('news/' . $news->id, 'public');
            }
        };

        return redirect('/admin/news')->with('success', 'Новость успешно сохранена');
    }

    public function deleteImage(Request $request)
    {
        if(!$request->url) {
            return false;
        }
        return Storage::delete($request->url);
    }

    public function create()
    {
        $categories = [];

        $allCategories = \App\Category::all();

        foreach ($allCategories as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('admin.news.create', [
            'categories' => $categories
        ]);
    }

    public function edit($id)
    {
        $news = News::find($id);

        $categories = [];

        $allCategories = \App\Category::all();

        foreach ($allCategories as $category) {
            $categories[$category->id] = $category->name;
        }

        return view('admin.news.edit', [
            'news' => $news,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'slug' =>  'required',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        $news = News::find($id);
        $news->author_id = Auth::id();
        $news->title =  $request->get('title');
        $news->slug = $request->get('slug');
        $news->category_id = $request->get('category_id');
        $news->content = $request->get('content');
        $news->updated_at = date('Y-m-d H:i:s');
        if($news->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('news/' . $news->id, 'public');
            }
        };

        return redirect('/admin/news')->with('success', 'Новость обновлена!');
    }

    public function deleteItem($id = null)
    {
        if($id) {
            $news = News::find($id);
            $news->delete();

            return redirect('/admin/news')->with('success', 'Новость удалена!');
        }

        return redirect('/admin/news')->with('error', 'Нет ID!');
    }
}
