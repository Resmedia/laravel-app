<?php

namespace App\Http\Controllers\Admin;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: rogozhuk
 * Date: 18.02.20
 * Time: 13:26
 */

class ResourceController extends Controller
{
    public function index(Request $request): View
    {
        $models = Resource::search($request->input('q'))
            ->orderBy('id')
            ->paginate(20);

        return view('admin.resource.index', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $resource = new Resource();

        return $this->saveData($request, $resource);
    }

    public function create()
    {
        return view('admin.resource.create');
    }

    public function edit($id)
    {
        $resource = Resource::find($id);

        return view('admin.resource.edit', [
            'resource' => $resource,
        ]);
    }

    public function update(Request $request, $id)
    {
        $resource = Resource::find($id);

        if(!empty($resource)) {
            return $this->saveData($request, $resource);
        }

        return false;
    }

    protected function saveData(Request $request, $resource)
    {
        $exists = $resource->exists;
        /** @var $resource \App\Resource */
        $validator = Validator::make($request->all(), [
            'name' => ($exists && $resource->name == $request->get('name')) ? 'required|max:120' : 'required|max:220',
            'url' => ($exists && $resource->url == $request->get('url')) ? 'required|max:120' : 'required|unique:resources|max:220',
        ], $resource->messages());

        $url = '/admin/resource' . ($exists ? '/' . $resource->id . '/edit' : '/create');

        if ($validator->fails()) {
            return redirect($url)
                ->withErrors($validator)
                ->withInput();
        } else {
            $resource->fill([
                'name' => $request->get('name'),
                'url' => $request->get('url'),
            ]);

            if($resource->save()){
                return redirect('/admin/resource')->with('success', 'RRS успешно ' . ($exists ? 'обновлена!' : 'сохранена!'));
            };

            return false;
        }
    }

    public function delete($id)
    {
        $resource = Resource::find($id);

        if(!empty($resource)) {
            $resource->delete();
            return redirect('/admin/resource')->with('success', 'RRS удалена!');
        }

        return redirect('/admin/resource')->with('error', 'Нет такой RSS!');
    }
}