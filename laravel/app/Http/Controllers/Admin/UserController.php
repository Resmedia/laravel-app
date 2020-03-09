<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;
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
            ->where('id', '<>', Auth::id())
            ->latest()
            ->paginate(20);

        return view('admin.users.index', [
            'models' => $models
        ]);
    }

    public function store()
    {
        $user = new User();

        return $this->saveData(request(), $user);
    }

    public function create()
    {
        return view('admin.users.create', [
            'rules' => User::$roles
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.users.edit', [
            'user' => $user,
            'rules' => User::$roles
        ]);
    }

    public function update($id)
    {
        $user = User::find(intval($id));

        if (!empty($user)) {
            return $this->saveData(request(), $user);
        }

        return false;
    }

    protected function saveData(Request $request, $user)
    {
        $rules = [
            'name' => 'required|max:100|min:3',
            'email' => 'required|max:100|min:3' . ($user->exists && $user->email == $request->post('email') ? '' : '|unique:users'),
            'newPassword' => $user->exists && !$request->post('newPassword') ? '' : 'required|min:5',
            'rules' => 'required'
        ];
        /** @var $user User */
        $validator = Validator::make($request->all(), $rules, $user->messages());

        $exists = $user->exists;
        $url = '/admin/users' . ($exists ? '/' . $user->id . '/edit' : '/create');

        if ($validator->fails()) {
            return redirect($url)
                ->withErrors($validator)
                ->withInput();
        } else {

            $user->fill([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'rules' => intval($request->post('rules')),
                'password' => $request->post('newPassword') ? Hash::make($request->post('newPassword')) : $user->password,
            ]);

            if ($user->save()) {
                if ($request->hasFile('file')) {
                    $request->file('file')->store('users/' . $user->id);
                }

                return redirect('/admin/users')
                    ->with('success', 'Пользователь успешно' . ($exists ? ' обновлен!' : ' сохранен!'));
            };
        }

        return false;
    }

    public function deleteImage(Request $request)
    {
        if ($request->get('url')) {
            if (Storage::delete($request->get('url'))) {
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

    public function delete($id = null)
    {
        if ($id) {
            $user = User::find($id);
            $user->delete();

            return redirect('/admin/users')->with('success', 'Пользователь удален!');
        }

        return redirect('/admin/users')->with('error', 'Нет ID!');
    }
}
