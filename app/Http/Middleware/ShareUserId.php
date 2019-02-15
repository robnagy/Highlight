<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ShareUserId
{
    /**
     * Share $highlight_user_id var with all views,
     * to inject as highlight-user-id meta field
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        View::share('highlight_user_id', Auth::check() ? Auth::user()->id : 'guest');
        return $next($request);
    }
}
