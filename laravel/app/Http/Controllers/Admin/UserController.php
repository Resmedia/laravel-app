<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $models = User::search($request->input('q'))
            ->latest()
            ->paginate(20);

        return view('admin.users.index', [
            'models' => $models
        ]);
    }

    public function store(Request $request)
    {
        $user = new User($request->all());

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:user|max:255',
            'slug' =>  'required|unique:user|max:255',
            'category_id' => 'required',
            'content' => 'required',
        ], $user->messages());

        if ($validator->fails()) {
            return redirect('/admin/users/create')
                ->withErrors($validator)
                ->withInput();
        }

        $user->fill([
            'author_id' => Auth::id(),
            'posted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if($user->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('users/' . $user->id);
            }
        };

        return redirect('/admin/users')->with('success', 'Новость успешно сохранена');
    }

    public function create()
    {
        $rules = [
            1 => 'Администратор',
            2 => 'Пользователь'
        ];

        return view('admin.users.create', [
            'rules' => $rules
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        $rules = [
            1 => 'Администратор',
            2 => 'Пользователь'
        ];

        return view('admin.users.edit', [
            'user' => $user,
            'rules' => $rules
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'name' => ($user->title !== $request->get('name')) ? 'required|unique:users|max:100' : 'required|max:100',
            'email' => ($user->slug !== $request->get('email')) ? 'required|unique:users|max:120' : 'required|max:100',
            'rules' => 'required',
        ], $user->messages());

        if ($validator->fails()) {
            return redirect("/admin/users/edit/$id")
                ->withErrors($validator)
                ->withInput();
        }

        $user->fill([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'rules' => $request->get('rules'),
            'password' => Hash::make($request->get('newPassword')),
        ]);
        if($user->save()){
            if($request->hasFile('file')) {
                $request->file('file')->store('user/' . $user->id);
                return redirect('admin/users/edit/' . $user->id)->with('success', 'Фото добавлено!');
            }
        };

        return redirect('/admin/users')->with('success', 'Пользователь обновлен!');
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
            $user = User::find($id);
            $user->delete();

            return redirect('/admin/users')->with('success', 'Пользователь удален!');
        }

        return redirect('/admin/users')->with('error', 'Нет ID!');
    }
}
