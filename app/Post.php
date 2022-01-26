<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
        'thumbnail',
        'slug',
        'status',
    ];

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            if (!request()->routeIs('admin/*'))
                $builder->whereHas('category', function ($query) {
                    $query->where('status', '1');
                });
        });
    }


    public function getStatusAttribute($value)
    {
        return $value == 1 ? __("lang.Published") : __("lang.Not Published");
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function scopePagination($query, $number = 12)
    {
        return $query->paginate($number);
    }
}
