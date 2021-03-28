<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message_title extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
    ];

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }

    public function messages()
    {
        return $this->hasMany('App\Message','id','title_id');
    }
}
