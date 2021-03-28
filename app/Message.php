<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Message extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title_id',
        'body',
        'read',
        'user_id',
        'name',
        'email',
    ];

    
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function message_title()
    {
        return $this->belongsTo('App\Message_title','title_id','id');
    }
}
