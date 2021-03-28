<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website_content_area extends Model
{
    protected $fillable = [
        'area',
    ];


    public function website_contents()
    {
        return $this->hasMany('App\Website_content');
    }
}
