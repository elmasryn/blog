<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use App\User;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('locale'))
            $locale = session()->get('locale');
        else {
            if(auth()->check() && isset(User::find(auth()->id())->profile->lang))
                $locale = User::find(auth()->id())->profile->lang;
            elseif(isset(setting()->default_lang))
                $locale = setting()->default_lang;
            else
            $locale = App::getLocale();
        }

        App::setLocale($locale);
        return $next($request);
    }
}
