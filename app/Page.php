<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Page extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'body',
        'slug',
        'status',
    ];

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }

    public function getStatusAttribute($value){
        return $value == 1 ? __("lang.Published") : __("lang.Not Published");
    }
}
