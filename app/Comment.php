<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'body',
        'name',
        'cookie',
        'status',
    ];
    


    public function getStatusAttribute($value){
        return $value == 1 ? __("lang.Published") : __("lang.Not Published");
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function scopePagination($query, $number = 12)
    {
        return $query->paginate($number);
    }
}
