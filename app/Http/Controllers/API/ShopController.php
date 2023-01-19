<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 一覧取得
    public function getShopList(Request $request)
    {
        $customerId = Auth::user()->customer_id;
        $response = array();

        $shops = Shop::where('customer_id', $customerId)
            ->where('del_flg', '0')
            ->orderBy('id')
            ->get();

        $shopArray = array();
        foreach ($shops as $key => $value) {
            $shopData = array();
            $shopData['id'] = $value->id;
            $shopData['customer_id'] = $value->customer_id;
            $shopData['shop_name'] = $value->shop_name;
            $shopData['plan_id'] = $value->plan_id;
            $shopData['postal_code'] = $value->postal_code;
            $shopData['address'] = $value->address;
            $shopData['building_name'] = $value->building_name;
            $shopData['tel'] = $value->tel;
            $shopData['fax'] = $value->fax;
            $shopArray[] = $shopData;
        }
        $response['shops'] = $shopArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
        // 一覧取得
    public function getShopUserList(Request $request, $id)
    {
        $response = array();

        $shopuser = ShopUser::where('user_id', $id)
            ->where('del_flg', '0')
            ->orderBy('id')
            ->get();

        $shopUserArray = array();
        foreach ($shops as $key => $value) {
            $shopUserData = array();
            $shopUserData['id'] = $value->id;
            $shopUserData['customer_id'] = $value->customer_id;
            $shopUserData['shop_id'] = $value->shop_id;
            $shopUserData['user_id'] = $value->user_id;
            $shopUserData['authority_id'] = $value->authority_id;
            $shopUserArray[] = $shopUserData;
        }
        $response['shopusers'] = $shopUserArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}