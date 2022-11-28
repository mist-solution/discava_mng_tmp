<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectShopController extends Controller
{
    /**
     * changeShopId
     *
     * @return null
     */
    public function changeShopId(Request $request)
    {
        // 選択された店舗ID
        $shop_id = $request->input('shop_id');

        // 店舗ユーザを取得
        $shopuser = ShopUser::where('user_id', Auth::id())
            ->where('shop_id', $shop_id)
            ->first();

        // 店舗ID、権限を設定
        $request->session()->put('shop_id', $shopuser->shop_id);
        $request->session()->put('authority_id', $shopuser->authority_id);
    }

}
