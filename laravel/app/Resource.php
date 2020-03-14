<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer $id
 * @property string $name
 * @property string $url
 */
class Resource extends Model
{

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'url',
    ];

    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        }
    }

    public function messages()
    {
        return [
            'url.required' => 'Контент необходимо заполнить',
            'name.required' => 'URL обязательно к заполнению',
            'url.unique' => 'URL должен быть уникален',
            'url.max' => 'URL не должен превышать 220 знаков',
        ];
    }
}
