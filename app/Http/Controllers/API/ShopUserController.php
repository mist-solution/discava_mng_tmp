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

        $shopUsers = ShopUser::with('shop')
            ->where('user_id', Auth::id())
            ->where('del_flg', '0')
            ->get();

        $shopUserArray = array();
        foreach ($shopUsers as $key => $shopUsers) {
            $shopUserData = array();
            $shopUserData['id'] = $shopUsers->id;
            $shopUserData['customer_id'] = $shopUsers->customer_id;
            $shopUserData['shop_id'] = $shopUsers->shop_id;
            $shopUserData['user_id'] = $shopUsers->user_id;
            $shopUserData['authority_id'] = $shopUsers->authority_id;
            $shopUserData['shop_name'] = $shopUsers->shop->shop_name;
            $shopUserArray[] = $shopUserData;
        }
        $response['shopUsers'] = $shopUserArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

    // セッション選択中の店舗情報を取得
    public function getLoginUserShopSelect(Request $request)
    {
        $shopId = $request->session()->get('shop_id');
        $response = array();

        $shopUsers = ShopUser::with('shop')
            ->where('shop_id', $shopId)
            ->where('user_id', Auth::id())
            ->where('del_flg', '0')
            ->get();

        $shopSelectArray = array();
        foreach ($shopUsers as $key => $shopUsers) {
            $shopSelectData = array();
            $shopSelectData['id'] = $shopUsers->id;
            $shopSelectData['customer_id'] = $shopUsers->customer_id;
            $shopSelectData['shop_id'] = $shopUsers->shop_id;
            $shopSelectData['user_id'] = $shopUsers->user_id;
            $shopSelectData['authority_id'] = $shopUsers->authority_id;
            $shopSelectData['shop_name'] = $shopUsers->shop->shop_name;
            $shopSelectArray[] = $shopSelectData;
        }

        $response['shopSelect'] = $shopSelectArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

}
