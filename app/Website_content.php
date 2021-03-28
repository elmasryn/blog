<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website_content extends Model
{
    protected $fillable = [
        'value', 'link', 'area_id',
    ];

    public function website_content_area()
    {
        return $this->belongsTo('App\Website_content_area','area_id');
    }
}
