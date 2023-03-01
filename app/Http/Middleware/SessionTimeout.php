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
    // protected $session;

    // public function __construct(SessionManager $session)
    // {
    //     $this->session = $session;
    // }
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
        log::info("SESSION 残り(秒)");
        log::info($remainingLifetime);
        log::info($request->session()->has('user_id'));

        if ($remainingLifetime <= 0) {
            log::info("sessionStartTime<=0");
            Auth::logout();
            $request->session()->flush();

            // if (!$request->session()->has('user_id')) {
            //     log::info($request->session()->has('user_id'));
            //     return redirect('/login');
            // }
            // $request->session()->put('url.intended', '/login');

            return redirect('/login');


            // return response()->refresh();
            // return redirect()->route('login');
            // return redirect()->to('/login');

            // return redirect()->intended('/login');
            // return redirect('/login')->with('error', '您的登录已超时，请重新登录。');


            // if (!$remainingLifetime) {
            //     Auth::logout();
            //     return redirect()->intended('/login');
            // }
            // }
            // $user = Auth::guard()->user();
            // if (!Auth::check()) {
            //     if (!$user) {
            //         if ($sessionStartTime) {
            //             $remainingLifetime = ($sessionLifetime - ($currentTime - $sessionStartTime));
            //             log::info("剩餘存活時間(秒)");
            //             log::info($remainingLifetime);

            //             if (!$remainingLifetime) {
            //                 Auth::logout();
            //                 return redirect()->intended('/login');
            //             }
            //         }
            //     }
        }
        return $next($request);
    }
}
