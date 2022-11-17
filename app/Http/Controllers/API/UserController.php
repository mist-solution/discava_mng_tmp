<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $users = User::whereCustomerId('1')->get();
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
            'name' => $request->name,
            'email' => $request->email,
        ];
        $customer = DB::table('customers')->where('code', $request->customer)->first();
        $user = User::find($id);
        $user->update($update);
        $user->customers()->sync($customer->id);

        Log::info('ユーザ更新');
        Log::debug(print_r($update, true));
        Log::debug($customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteAll(Request $request)
    {
        $user_ids = $request->all();
        User::whereIn('id', $user_ids)->delete();

        Log::info('ユーザ削除');
        Log::debug(print_r($user_ids, true));
    }
}
