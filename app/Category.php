<?php

namespace App;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'desc_en',
        'desc_ar',
        'slug',
        'status',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    // protected static function booted()
    // {
    //     static::addGlobalScope(new StatusScope);
    // }

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            if (!request()->routeIs('admin/*'))
                $builder->where('status', '1');
        });
    }


    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }

    public function getStatusAttribute($value)
    {
        return $value == 1 ? __("lang.Published") : __("lang.Not Published");
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function scopePagination($query, $number = 6)
    {
        return $query->paginate($number);
    }
}
