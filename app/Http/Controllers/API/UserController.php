<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopUser;
use App\Models\User;
use DateTime;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\EndUserRegistRequest;
use App\Http\Requests\EndUserUpdateRequest;

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
        \Debugbar::info("info");
        //        log::info("呼ばれてる");
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

        //        log::info("ユーザー登録完了");
        $shopList = $request['shopList'];

        //        Log::info($shopList);
        for ($i = 0; $i < count($shopList); $i++) {
            $shopUser = new ShopUser();

            // 該当なしはスキップ
            if (strcmp($shopList[$i]['model'], "none") == 0) {
                continue;
            }

            $shopUser['customer_id'] = Auth::user()->customer_id;
            $shopUser['shop_id'] = $shopList[$i]['id'];
            $shopUser['user_id'] = DB::table('users')->latest('id')->first()->id;
            $shopUser['authority_set_id'] = $shopList[$i]['model'];
            $shopUser['add_account'] = Auth::user()->id;
            $shopUser['upd_account'] = Auth::user()->id;
            $shopUser['del_flg'] = '0';
            $shopUser['created_at'] = new DateTime();
            $shopUser['updated_at'] = new DateTime();

            $shopUser->save();
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
        $List =  $request->all();
        $update = [
            'name' => $List['name'],
            'email' => $List['email'],
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime()
        ];

        $user = User::find($id);
        $user->update($update);

        $shopList = $List['shopList'];

        ShopUser::where('user_id', $id)->delete();

        for ($i = 0; $i < count($shopList); $i++) {
            $shops = new ShopUser();
            $shops['customer_id'] = Auth::user()->customer_id;
            $shops['shop_id'] = $shopList[$i]['id'];
            $shops['user_id'] = $id;
            $shops['authority_set_id'] = $shopList[$i]['model'];
            $shops['add_account'] = Auth::user()->id;
            $shops['upd_account'] = Auth::user()->id;
            $shops['del_flg'] = '0';
            $shops['created_at'] = new DateTime();
            $shops['updated_at'] = new DateTime();

            if ($shops['authority_set_id'] === "none") {
            } else {
                $shops->save();
            }
        }
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
        for ($i = 0; $i < count($user_ids); $i++) {
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

    //sessionのUser_idからログインユーザーの情報取得
    public function getUserInfo(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $response = array();

        $UserInfo = User::where('id', $userId)
            ->get();

        $userInfoArray = array();
        foreach ($UserInfo as $key => $value) {
            $userData = array();
            $userData['name'] = $value->name;
            $userInfoArray[] = $userData;
        }

        $response['userInfo'] = $userInfoArray;
        $response['message'] = 'success_ui';
        return new JsonResponse($response);
    }

    // バリデーションリクエスト(アカウント追加)
    public function registStore(EndUserRegistRequest $request)
    {
        if (!$request->validated()) {
            return redirect()->back()->withInput()->withErrors($request->errors());
        }
    }

    // バリデーションリクエスト(アカウント更新)
    public function updateStore(EndUserUpdateRequest $request)
    {
        if (!$request->validated()) {
            return redirect()->back()->withInput()->withErrors($request->errors());
        }
    }

    //サジェスト機能
    public function suggest(Request $request)
    {
        $response = array();
        $users = User::where('customer_id', Auth::user()->customer_id)
            ->where('name','LIKE',"%{$request->input('suggestname')}%")
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

    // 権限一括更新
    public function updateAuthority(Request $request , $id , $No)
    {
        $update = [
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime()
        ];

        $user = User::find($id);
        $user->update($update);

        $shopList = Shop::where('customer_id', Auth::user()->customer_id)
            ->where('del_flg', '0')
            ->get();


        if($No == 2){
            ShopUser::where('user_id', $id)->delete();
            for ($i = 0; $i < count($shopList); $i++) {
                $shops = new ShopUser();
                $shops['customer_id'] = Auth::user()->customer_id;
                $shops['shop_id'] = $shopList[$i]['id'];
                $shops['user_id'] = $id;
                $shops['authority_set_id'] = 1;
                $shops['add_account'] = Auth::user()->id;
                $shops['upd_account'] = Auth::user()->id;
                $shops['del_flg'] = '0';
                $shops['created_at'] = new DateTime();
                $shops['updated_at'] = new DateTime();
    
                $shops->save();
            }
        } else if ($No == 3){
            ShopUser::where('user_id', $id)->delete();
            for ($i = 0; $i < count($shopList); $i++) {
                $shops = new ShopUser();
                $shops['customer_id'] = Auth::user()->customer_id;
                $shops['shop_id'] = $shopList[$i]['id'];
                $shops['user_id'] = $id;
                $shops['authority_set_id'] = 2;
                $shops['add_account'] = Auth::user()->id;
                $shops['upd_account'] = Auth::user()->id;
                $shops['del_flg'] = '0';
                $shops['created_at'] = new DateTime();
                $shops['updated_at'] = new DateTime();
    
                $shops->save();
            }
        } else if ($No == 4){
            ShopUser::where('user_id', $id)->delete();
            for ($i = 0; $i < count($shopList); $i++) {
                $shops = new ShopUser();
                $shops['customer_id'] = Auth::user()->customer_id;
                $shops['shop_id'] = $shopList[$i]['id'];
                $shops['user_id'] = $id;
                $shops['authority_set_id'] = 3;
                $shops['add_account'] = Auth::user()->id;
                $shops['upd_account'] = Auth::user()->id;
                $shops['del_flg'] = '0';
                $shops['created_at'] = new DateTime();
                $shops['updated_at'] = new DateTime();
    
                $shops->save();
            }
        } else if ($No == 5){
            ShopUser::where('user_id', $id)->delete();
        }
    }
}
