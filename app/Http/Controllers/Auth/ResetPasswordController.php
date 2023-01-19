<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    use ThrottlesLogins;
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/password/complete';

    // ログインに使用するユーザ名（メールアドレス）
    public function username()
    {
        return 'email';
    }

    // ResetsPasswords クラスのメソッドをオーバーライドでカスタマイズ
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
        // パスワードリセット後、自動でログインしない。
        //$this->guard()->login($user);
    }

    // パスワードリセットをオーバーライドでカスタマイズ
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        // リクエストユーザを取得して、元のパスワードと検証する
        $user = User::where('email', $request['email'])->first();
        $request->validate([
            // $attribute = 検証項目
            // $value = 入力された新パスワード
            // $fail = 結果は失敗する際のメッセージ
            'password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (Hash::check($value, $user->password)) {
                    $fail('現在のパスワードとは異なるパスワードの入力をお願いします。');
                }
            }],
        ]);

        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // アカウントロックを解除する。
        $this->clearLoginAttempts($request);

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
}
