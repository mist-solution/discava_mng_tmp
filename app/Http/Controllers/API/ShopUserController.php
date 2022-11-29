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

        $shopSelectArray = array();
        foreach ($shopUsers as $key => $value) {
            $shopSelectData = array();
            $shopSelectData['id'] = $value->id;
            $shopSelectData['customer_id'] = $value->customer_id;
            $shopSelectData['shop_id'] = $value->shop_id;
            $shopSelectData['user_id'] = $value->user_id;
            $shopSelectData['authority_id'] = $value->authority_id;
            $shopSelectData['shop_name'] = $value->shop->shop_name;
            $shopSelectArray[] = $shopSelectData;
        }
        $response['shopUsers'] = $shopSelectArray;
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
            ->first();

        $shopSelectArray = array();
        foreach ($shopUsers as $key => $value) {
            $shopSelectData = array();
            $shopSelectData['id'] = $value->id;
            $shopSelectData['customer_id'] = $value->customer_id;
            $shopSelectData['shop_id'] = $value->shop_id;
            $shopSelectData['user_id'] = $value->user_id;
            $shopSelectData['authority_id'] = $value->authority_id;
            $shopSelectData['shop_name'] = $value->shop->shop_name;
            $shopSelectArray[] = $shopSelectData;
        }
        $response['shopSelect'] = $shopSelectArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

}
