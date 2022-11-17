<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use DB;

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
        //ToDo:ログインユーザのCustomerIdを条件にする。
        $users = User::where('customer_id', '1')->where('del_flg', '0')->get();
        $userArrays = array();
        foreach ($users as $key => $value) {
            $userArray = array();
            $userArray['id'] = $value->id;
            $userArray['login_user_id'] = $value->login_user_id;
            $userArray['name'] = $value->name;
            $userArray['email'] = $value->email;
            $userArray['customer_id'] = $value->customer_id;
            $userArray['created_at'] = $value->created_at;
            $userArray['updated_at'] = $value->updated_at;
            $userArrays[] = $userArray;
        }
        $response['users'] = $userArrays;
        $response['message'] = 'success';
        return new JsonResponse($response);
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
            'login_user_id' => $request->login_user_id,
            'name' => $request->name,
            'email' => $request->email,
        ];
//        $customer = DB::table('customers')->where('code', $request->customer)->first();
        $user = User::find($id);
        $user->update($update);
//        $user->customers()->sync($customer->id);

        Log::info('ユーザ更新');
        Log::debug(print_r($update, true));
//        Log::debug($customer->id);
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
}
