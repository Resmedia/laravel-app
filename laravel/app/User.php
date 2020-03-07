<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        }
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
