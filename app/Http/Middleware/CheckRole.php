<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, ...$roles)
    {
        if(!$request->user())
            return redirect(adminurl('login'));
        else{
            foreach ($roles as $role) {
                // if($request->user()->roles[0 ?? 1 ?? 2 ?? 3 ?? 4 ?? 5]->name == $role)
                if(count(auth()->user()->roles->pluck('name')->intersect($role)) > 0)
                    return $next($request);
            }
            return redirect(url(''))->with('error',trans('lang.You do not have Admin access'));
        }       
    }

}
