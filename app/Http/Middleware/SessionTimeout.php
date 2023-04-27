<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class SessionTimeout
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

        $sessionLifetime = config('session.lifetime') * 60; // seconds
        $sessionStartTime = $request->session()->get('auth.password_confirmed_at');
        $currentTime = time();
        $remainingLifetime = ($sessionLifetime - ($currentTime - $sessionStartTime));
        if ($remainingLifetime <= 0) {
            Auth::logout();
            $request->session()->flush();
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }
        return $next($request);
    }
}
