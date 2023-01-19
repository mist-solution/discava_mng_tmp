<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopUser;
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
        // $id : 
    public function getShopUserList(Request $request, $id)
    {
        $response = array();
        $shopuser = ShopUser::leftJoin('authority_sets',
        function ($join) use ($id) {
            $join->on('shop_users.authority_set_id', '=', 'authority_sets.id');
        })
        ->where('user_id', $id)
            ->where('shop_users.del_flg', '0')
            ->orderBy('shop_users.id')
            ->get();


        $shopUserArray = array();
        foreach ($shopuser as $key => $value) {
            $shopUserData = array();
            $shopUserData['id'] = $value->id;
            $shopUserData['customer_id'] = $value->customer_id;
            $shopUserData['shop_id'] = $value->shop_id;
            $shopUserData['user_id'] = $value->user_id;
            $shopUserData['authority_set_id'] = $value->authority_set_id;
            $shopUserData['authority_name'] = $value->name;
            $shopUserArray[] = $shopUserData;
        }
        $response['shopusers'] = $shopUserArray;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}