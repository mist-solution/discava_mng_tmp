<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopUserController extends Controller
{
    // 一覧取得
    public function getLoginUserShopList(Request $request)
    {
        // $shopId = $request->session()->get('shop_id');
        $response = array();

        $shopUsers = ShopUser::with('customer_id', 'shop_id', 'user_id')
            ->where('user_id', Auth::id())
            ->where('del_flg', '0')
            ->get();

        $shopUserArray = array();
        foreach ($shopUsers as $key => $value) {
            $shopUserData = array();
            $shopUserData['id'] = $value->id;
            $shopUserData['customer_id'] = $value->customer_id;
            $shopUserData['shop_id'] = $value->shop_id;
            $shopUserData['user_id'] = $value->user_id;
            $shopUserData['authority_id'] = $value->authority_id;
            $shopUserData['shop_name'] = $value->shop_id->shop_name;
            $shopUserArray[] = $shopUserData;
        }
        $response['shopUsers'] = $shopUserArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}
