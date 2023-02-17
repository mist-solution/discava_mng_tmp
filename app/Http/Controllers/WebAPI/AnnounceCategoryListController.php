<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\Shop;
use App\Models\AnnounceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;

class AnnounceCategoryListController extends Controller
{
    // protected $fakeToken = 'X-DiscavaMATE-API-Token';
    // protected $fakeShopId = 1;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * 
     *
     * @return response
     */
    public function get(Request $request)
    {
        $token = null;
        $shopId = null;
        $response = array();

        // $token = $request->header('X-DiscavaMATE-API-Token') ?? $this->fakeToken;
        // $shopId = $request->input('shop_id') ?? $this->fakeShopId;

        // ヘッダーのX-DiscavaMATE-API-Tokenを取得
        $token = $request->header('X-DiscavaMATE-API-Token');
        if (is_null($token)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        // // 合致するtokenから店舗を取得
        $records = Shop::all();
        $response = array();
        foreach ($records as $key => $value) {
            if ($token == $value->webapi_token) {
                $shopId = $value->id;
                break;
            }
        }
        if (is_null($shopId)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        // 店舗のお知らせカテゴリー一覧を取得する
        $announceCategories = AnnounceCategory::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->get();

        return $announceCategories;
    }
}
