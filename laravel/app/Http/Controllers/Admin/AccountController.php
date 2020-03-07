<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function update(Request $request)
    {
        $model = Auth::user();

        if ($request->isMethod('post')) {

            $errors = Validator::make($request->all(), $this->validateRules(), $this->messages());

            if ($errors->fails()) {
                return redirect('admin/account')
                    ->withErrors($errors)
                    ->withInput();
            }

            if (Hash::check($request->post('oldPassword'), $model->password)) {
                $errors['oldPassword'][] = 'Неверно введен текущий пароль';
                return redirect('admin/account')
                    ->withErrors($errors)
                    ->withInput();
            }

            $model->fill([
                'name' => $request->post('name'),
                'password' => Hash::make($request->post('newPassword')),
                'email' => $request->post('email')
            ]);

            $model->save();

            $request->session()->flash('success', 'Вы успешно сменили свои данные!');
        }

        return view('admin.main.account', [
            'model' => $model
        ]);
    }

    public function validateRules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'oldPassword' => 'required',
            'newPassword' => 'required|min:5'
        ];
    }

    public function attributeNames()
    {
        return [
            'name' => 'ФИО',
            'email' => 'Email',
            'newPassword' => 'Новый пароль',
            'oldPassword' => 'Старый пароль',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ФИО обязательно',
            'email.required'  => 'Email необходимо заполнить',
            'oldPassword.required' => 'Страый пароль обязателен к заполнению',
            'newPassword.required' => 'Новый пароль обязателен к заполнению',
            'email.unique' => 'Email должен быть уникален',
            'title.unique' => 'Название должно быть уникально',
            'newPassword.min' => 'Пароь минимум 5 знаков',
            'name.max' => 'ФИО не может быть более 100 знаков',
            'name.string' => 'ФИО не может содержать цифры',
        ];
    }

}
