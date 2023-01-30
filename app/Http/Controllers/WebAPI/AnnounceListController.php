<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Storage;

class AnnounceListController extends Controller
{
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

        // ヘッダーのX-DiscavaMATE-API-Tokenを取得
        $token = $request->header('X-DiscavaMATE-API-Token');
        if(is_null($token)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        // 合致するtokenから店舗を取得
        $records = Shop::all();
        $response = array();
        foreach($records as $key => $value) {
            if ($token == $value->webapi_token) {
                $shopId = $value->id;
                break;
            }
        }
        if(is_null($shopId)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }
        
        // 店舗のお知らせ一覧を取得する
        $records = Announce::with('announce_categories')
            ->where('shop_id', $shopId)
            ->where('approval_status', '2')
            ->where('del_flg', '0')
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        
        $announceArrays = array();
        foreach($records as $key => $value) {
            $announceArray = array();
            $announceArray['id'] = $value->id;
            $announceArray['shop_id'] = $value->shop_id;
            $announceArray['announce_category_id'] = $value->announce_category_id;
            $announceArray['announce_category_name'] = $value->announce_categories->category_name;
            $announceArray['start_date'] = $value->start_date;
            $announceArray['end_date'] = $value->end_date;
            $announceArray['title'] = $value->title;
            $announceArray['thumbnail_img_path'] = $value->thumbnail_img_path;
            $announceArray['thumbnail_img_filename'] = $value->thumbnail_img_filename;
//            $announceArray['contents'] = $value->contents;
            $announceArrays[] = $announceArray;
        }
        return $announceArrays;
    }
}

