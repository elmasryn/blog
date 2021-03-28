<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'website_en',
        'website_ar',
        'default_lang',
        'email',
        'description',
        'keywords',
        'icon',
        'post_publish_status',
        'comment_publish_status',
        'comment_status',
        'comment_message',
        'website_status',
        'website_message',
    ];

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }
}
