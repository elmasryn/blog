<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Locale extends Controller

{
    
    public function locale($locale) {


        if (array_key_exists($locale, locales())){
            session(['locale' => $locale]);
            return back();
        }else
        abort(404);
    }
}
