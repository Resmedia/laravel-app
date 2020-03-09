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
            ->latest()
            ->paginate(20);

        return view('admin.news.index', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $news = new News();

        return $this->saveData($request, $news);
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

        if(!empty($news)) {
            return $this->saveData($request, $news);
        }

        return false;
    }

    protected function saveData(Request $request, $news)
    {
        $exists = $news->exists;
        /** @var $news News */
        $validator = Validator::make($request->all(), [
            'title' => ($exists && $news->title == $request->get('title')) ? 'required|max:120' : 'required|unique:news|max:120',
            'slug' => ($exists && $news->slug == $request->get('slug')) ? 'required|max:120' : 'required|unique:news|max:120',
            'category_id' => 'required',
            'content' => 'required',
        ], $news->messages());

        $url = '/admin/news' . ($exists ? '/' . $news->id . '/edit' : '/create');

        if ($validator->fails()) {
            return redirect($url)
                ->withErrors($validator)
                ->withInput();
        } else {
            $news->fill([
                'author_id' => Auth::id(),
                'title' => $request->get('title'),
                'slug' => $request->get('slug'),
                'category_id' => $request->get('category_id'),
                'content' => $request->get('content'),
            ]);

            if($news->save()){
                if($request->hasFile('file')) {
                    $request->file('file')->store('news/' . $news->id);
                }

                return redirect('/admin/news')->with('success', 'Новость успешно ' . ($exists ? 'обновлена!' : 'сохранена!'));
            };

            return false;
        }
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

    public function delete($id)
    {
        $news = News::find($id);

        if(!empty($news)) {
            $news->delete();
            return redirect('/admin/news')->with('success', 'Новость удалена!');
        }

        return redirect('/admin/news')->with('error', 'Нет такой новости!');
    }
}
