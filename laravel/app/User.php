<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $password
*/

class User extends Authenticatable
{
    const USER_GUEST = 0;
    const USER_ADMIN = 1;

    public static $roles = [
        self::USER_GUEST => 'Гость',
        self::USER_ADMIN => 'Администратор',
    ];

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rules'
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

    public function attributeNames(): array
    {
        return [
            'name' => 'ФИО',
            'email' => 'Email',
            'newPassword' => 'Новый пароль',
            'oldPassword' => 'Старый пароль',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ФИО обязательно',
            'email.required'  => 'Email необходимо заполнить',
            'oldPassword.required' => 'Страый пароль обязателен к заполнению',
            'newPassword.required' => 'Новый пароль обязателен к заполнению',
            'email.unique' => 'Email должен быть уникален',
            'email.max' => 'Email не может быть более 100 знаков',
            'email.min' => 'Email не может быть менее 3 знаков',
            'newPassword.min' => 'Пароль минимум 5 знаков',
            'oldPassword.min' => 'Пароль минимум 5 знаков',
            'name.max' => 'ФИО не может быть более 100 знаков',
            'name.min' => 'ФИО не может быть менее 3 знаков',
            'name.string' => 'ФИО не может содержать цифры',
        ];
    }
}
