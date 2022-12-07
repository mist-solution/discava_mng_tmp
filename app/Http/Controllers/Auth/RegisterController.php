<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/enduser';  //アカウント一覧に遷移

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  Request  $request
    //  * @return \App\Models\User
    //  */
    // public function create(Request $request)
    // {
    //     Log::info('ユーザ登録');
    //     Log::debug(print_r($request, true));

    //     $password = Hash::make($request['password']);

    //     $user = new User();

    //     $user['customer_id'] = Auth::user()->customer_id;
    //     $user['email'] = $request['email'];
    //     $user['name'] = $request['name'];
    //     $user['initial_password'] = $password;
    //     $user['password'] = $password;
    //     $user['email_verified_at'] = null;
    //     $user['remember_token'] = null;

    //     $user['add_account'] = Auth::user()->id;
    //     $user['upd_account'] = Auth::user()->id;
    //     $user['del_flg'] = '0';
    //     $user['created_at'] = new DateTime();
    //     $user['updated_at'] = new DateTime();

    //     $user->save();
    // }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
//        $data = $request->all();
//        $customer = DB::table('customers')->where('code', $data['customer'])->first();
//        $user->customers()->attach($customer->id);
        return new JsonResponse([], 201);
    }
}
