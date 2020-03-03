<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $models = News::search($request->input('q'))
            ->where(['author_id' => Auth::id()])
            ->latest()
            ->paginate(20);

        return view('admin.news.index', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $news = new News($request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:news|max:255',
            'slug' =>  'required|unique:news|max:255',
            'category_id' => 'required',
            'content' => 'required',
        ], $news->messages());

        if ($validator->fails()) {
            return redirect('/admin/news/create')
                ->withErrors($validator)
                ->withInput();
        }

        $news->fill([
            'author_id' => Auth::id(),
            'posted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($news->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('news/' . $news->id);
            }
        };

        return redirect('/admin/news')->with('success', 'Новость успешно сохранена');
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
        $news = News::find($id);

        $validator = Validator::make($request->all(), [
            'title' => ($news->title !== $request->get('title')) ? 'required|unique:news|max:120' : 'required|max:120',
            'slug' => ($news->slug !== $request->get('slug')) ? 'required|unique:news|max:120' : 'required|max:120',
            'category_id' => 'required',
            'content' => 'required',
        ], $news->messages());

        if ($validator->fails()) {
            return redirect("/admin/news/edit/$id")
                ->withErrors($validator)
                ->withInput();
        }

        $news->fill([
            'author_id' => Auth::id(),
            'title' => $request->get('title'),
            'slug' => $request->get('slug'),
            'category_id' => $request->get('category_id'),
            'content' => $request->get('content'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if($news->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('news/' . $news->id);
                return redirect('admin/news/edit/' . $news->id)->with('success', 'Фото добавлено!');
            }
        };

        return redirect('/admin/news')->with('success', 'Новость обновлена!');
    }

    public function deleteImage(Request $request)
    {
        if($request->get('url')) {
            if(Storage::delete($request->get('url'))){
                return json_encode([
                    'status' => 200,
                    'message' => 'Фото успешно удалено!'
                ]);
            }
        }

        return json_encode([
            'status' => 500,
            'message' => 'Нет url фото'
        ]);
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
