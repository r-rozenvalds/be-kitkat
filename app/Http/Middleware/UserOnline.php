<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class UserOnline
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(3);
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
        }        
        return $next($request);
    }
}