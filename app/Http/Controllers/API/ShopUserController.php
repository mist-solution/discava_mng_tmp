<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
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

        $shopUsers = ShopUser::leftJoin('shops', function($join) {
                $join->on('shops.id', '=', 'shop_users.shop_id');
            })->where('shop_users.user_id', '=', Auth::id())
            ->where('shops.customer_id', '=' , Auth::user()->customer_id)
            ->where('shops.del_flg', '=', '0')
            ->where('shop_users.del_flg', '=', '0')
            ->orderBy('shop_users.shop_id')
            ->get();

        $shopUserArray = array();
        foreach ($shopUsers as $key => $value) {
            $shopUserData = array();
            $shopUserData['id'] = $value->id;
            $shopUserData['customer_id'] = $value->customer_id;
            $shopUserData['shop_id'] = $value->shop_id;
            $shopUserData['user_id'] = $value->user_id;
            $shopUserData['authority_set_id'] = $value->authority_set_id;
            $shopUserData['shop_name'] = $value->shop->shop_name;
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
        foreach ($shopUsers as $key => $value) {
            $shopSelectData = array();
            $shopSelectData['id'] = $value->id;
            $shopSelectData['customer_id'] = $value->customer_id;
            $shopSelectData['shop_id'] = $value->shop_id;
            $shopSelectData['user_id'] = $value->user_id;
            $shopSelectData['authority_set_id'] = $value->authority_set_id;
            $shopSelectData['shop_name'] = $value->shop->shop_name;
            $shopSelectData['website_url'] = $value->shop->website_url;
            $shopSelectArray[] = $shopSelectData;
        }

        $response['shopSelect'] = $shopSelectArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

    // 対象ユーザの店舗一覧と権限を取得
    // $id : user_id
    public function getShopListWithAuthoritySet(Request $request, $id)
    {
        $shopUsers = Shop::leftJoin('shop_users',
            function ($join) use ($id) {
                $join->on('shops.id', '=', 'shop_users.shop_id')
                ->where('shop_users.customer_id', '=', Auth::user()->customer_id)
                ->where('shop_users.user_id', '=', $id)
                ->where('shop_users.del_flg', '0');
            })
            ->where('shops.customer_id', Auth::user()->customer_id)
            ->where('shops.del_flg', '0')
            ->select(
                'shops.id as shop_id',
                'shops.customer_id',
                'shops.shop_name',
                'shop_users.user_id',
                'shop_users.authority_set_id',
            )
            ->get();

        $response = array();
        $shopUserArray = array();
        foreach ($shopUsers as $key => $value) {
            $shopUserData = array();
            $shopUserData['customer_id'] = $value->customer_id;
            $shopUserData['shop_id'] = $value->shop_id;
            $shopUserData['shop_name'] = $value->shop_name;
            $shopUserData['user_id'] = $value->user_id;
            if(is_null($value->authority_set_id)) {
                $shopUserData['authority_set_id'] = 'none';
            } else {
                $shopUserData['authority_set_id'] = $value->authority_set_id;
            }
            $shopUserArray[] = $shopUserData;
        }

        $response['shopSelect'] = $shopUserArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}