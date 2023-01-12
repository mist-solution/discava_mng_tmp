<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 5;     // ログイン試行回数　　：回
    protected $decayMinutes = 10;   // ログインロックタイム：分

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'email';
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        //------------------------------
        // ここに追加したい処理を書く
        //------------------------------
        // 店舗ユーザの１行目を取得
        $shopuser = ShopUser::where('user_id', Auth::id())->first();

        // 店舗ID、権限、ユーザーIDを設定
        $request->session()->put('shop_id', $shopuser->shop_id);
        $request->session()->put('authority_set_id', $shopuser->authority_set_id);
        $request->session()->put('user_id', $shopuser->user_id);

        // ログイン後のリダイレクト
        return redirect()->intended($this->redirectPath());
    }

    /**
     * The user has logged out of the application.
     *
     * @param  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }

    /**
     * If account lock, display account locked form.
     *
     * @var string
     */
    public function sendLockoutResponse(Request $request)
    {
        return view('auth.passwords.lock');
    }
}
