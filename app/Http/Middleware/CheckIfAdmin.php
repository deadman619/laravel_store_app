<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
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
        if(!auth()->guest()) {
            if(auth()->user()->is_admin) {
                return $next($request);
            }
        }
        return redirect('/')->with('error', 'Unauthorized user');
    }
}
