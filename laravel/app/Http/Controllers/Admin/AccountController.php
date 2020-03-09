<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        /** @var $user \App\User*/
        if ($request->isMethod('post')) {

            $rules = [
                'name' => 'required|max:100',
                'email' => 'required' . ($user->email == $request->post('email') ? '' : '|unique:users') . '|max:120',
                'newPassword' =>
                    !$request->post('oldPassword') &&
                    !$request->post('newPassword') ?
                        '' : 'min:5|required',
                'oldPassword' =>
                    !$request->post('oldPassword') &&
                    !$request->post('newPassword') ?
                        '' : 'min:5required',
            ];

            $errors = Validator::make($request->all(), $rules, $user->messages());

            if ($errors->fails()) {
                return redirect('admin/account')
                    ->withErrors($errors)
                    ->withInput();
            } else {
                if (!empty($request->post('oldPassword')) &&
                    !empty($request->post('newPassword')) &&
                    !Hash::check($request->post('oldPassword'), $user->password)
                ) {
                    $error['oldPassword'][] = 'Неверно введен текущий пароль';
                    return redirect('admin/account')
                        ->withErrors($error)
                        ->withInput();
                } else {
                    $user->fill([
                        'name' => $request->post('name'),
                        'password' => $request->post('newPassword') ? Hash::make($request->post('newPassword')) : $user->password,
                        'email' => $request->post('email')
                    ]);

                    if($user->save()) {
                        $request->session()->flash('success', 'Вы успешно сменили свои данные!');
                    }
                }
            }
        }

        return view('admin.main.account', [
            'model' => $user
        ]);
    }
}
