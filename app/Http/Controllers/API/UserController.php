<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use App\Models\User;
use DateTime;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = array();
        $users = User::where('customer_id', Auth::user()->customer_id)
            ->where('del_flg', '0')
            ->get();
        $userArrays = array();
        foreach ($users as $key => $value) {
            $userArray = array();
            $userArray['id'] = $value->id;
            $userArray['name'] = $value->name;
            $userArray['email'] = $value->email;
            $userArray['customer_id'] = $value->customer_id;
            $userArray['created_at'] = $value->created_at;
            $userArray['updated_at'] = $value->updated_at;
            $userArrays[] = $userArray;
        }
        $response['users'] = $userArrays;
        $response['message'] = 'success';
        return $response;
    }

    public function showUser(Request $request, $id)
    {
        $value = User::where('customer_id', Auth::user()->customer_id)
            ->where('id', $id)
            ->where('del_flg', '0')
            ->first();

        $user = array();
        $user['id'] = $value->id;
        $user['name'] = $value->name;
        $user['email'] = $value->email;
        $user['customer_id'] = $value->customer_id;
        $user['created_at'] = $value->created_at;
        $user['updated_at'] = $value->updated_at;

        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \App\Models\User
     */
    public function register(Request $request)
    {
        $password = Hash::make($request['password']);

        $user = new User();

        $user['customer_id'] = Auth::user()->customer_id;
        $user['email'] = $request['email'];
        $user['name'] = $request['name'];
        $user['initial_password'] = $password;
        $user['password'] = $password;
        $user['email_verified_at'] = null;
        $user['remember_token'] = null;

        $user['add_account'] = Auth::user()->id;
        $user['upd_account'] = Auth::user()->id;
        $user['del_flg'] = '0';
        $user['created_at'] = new DateTime();
        $user['updated_at'] = new DateTime();

        $user->save();

        $shopList = $request['shopList'];

        for(shopList) {
            $shopUser = new ShopUser();

            $shopUser['customer_id'] = Auth::user()->customer_id;
            $shopUser['shop_id'] = $shopList[i].id;
            $shopUser['user_id'] = ????
            $shopUser['authority_set_id'] = $shopList[i].id;
            $shopUser['add_account'] = Auth::user()->id;
            $shopUser['upd_account'] = Auth::user()->id;
            $shopUser['del_flg'] = '0';
            $shopUser['created_at'] = new DateTime();
            $shopUser['updated_at'] = new DateTime();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = [
            'name' => $request->name,
            'email' => $request->email,
            'upd_account' => Auth::user()->id,
        ];

        $user = User::find($id);
        $user->update($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteAll(Request $request)
    {
        $user_ids = $request->all();

        // 店舗ユーザの物理削除
        ShopUser::whereIn('user_id', $user_ids)->delete();

        // 対象ユーザの論理削除
        for($i = 0; $i < count($user_ids); $i++) {
            // ユーザ情報を取得
            $user = User::where('id', $user_ids[$i])->first();
            // 誤って削除した場合など、同じメールアドレスを再使用することが考えられるため、IDとタイムスタンプで更新する。
            User::where('id', $user_ids[$i])->update([
                'del_flg' => 1,
                'email' => $user->email . '_' . $user->id . '_' . date("YmdHis"),
            ]);
        }

        Log::info('ユーザ削除');
        Log::debug(print_r($user_ids, true));
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteAccount(Request $request, $id)
    {
        // 店舗ユーザの物理削除
        ShopUser::where('user_id', $id)->delete();

        // 対象ユーザの論理削除
        // ユーザ情報を取得
        $user = User::where('id', $id)->first();
        // 誤って削除した場合など、同じメールアドレスを再使用することが考えられるため、IDとタイムスタンプで更新する。
        User::where('id', $id)->update([
            'del_flg' => 1,
            'email' => $user->email . '_' . $user->id . '_' . date("YmdHis"),
        ]);

        Log::info('ユーザ削除');
        Log::debug(print_r($id, true));
    }
}