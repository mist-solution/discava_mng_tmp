<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\AnnounceAttachment;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Storage;

class AnnounceDetailContoller extends Controller
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
    public function get(Request $request, String $id)
    {
        $token = null;
        $shopId = null;
        $announceId = null;
        $response = array();

        // $token = $request->header('X-DiscavaMATE-API-Token') ?? $this->fakeToken;
        // $shopId = $request->input('shop_id') ?? $this->fakeShopId;

        // ヘッダーのX-DiscavaMATE-API-Tokenを取得
        $token = $request->header('X-DiscavaMATE-API-Token');
        if (is_null($token)) {
            return response()->json([
                'message' => 'Internal Server Error(no header \'X-DiscavaMATE-API-Token\')'
            ], 500);
        }

        // 合致するtokenから店舗を取得
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
                'message' => 'Internal Server Error(not found shop id by token[' . $token . '])'
            ], 500);
        }

        // 店舗の指定されたお知らせIDを取得
        $announceId = $id;
        if (is_null($announceId)) {
            return response()->json([
                'message' => 'Internal Server Error(not found shop\'s announce id)'
            ], 500);
        }

        // 店舗の指定されたお知らせを取得する
        $value = Announce::with('announce_categories')
            ->where('id', $announceId)
            ->where('shop_id', $shopId)
            ->where('approval_status', '2')
            ->where('del_flg', '0')
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            // ->where('end_date', '>=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        if (is_null($value)) {
            return response()->json([
                'message' => 'Internal Server Error(not found shop\'s announce record)'
            ], 404);
        }

        // お知らせ
        $announce = array();
        $announce['id'] = $value->id;
        $announce['shop_id'] = $value->shop_id;
        $announce['announce_category_id'] = $value->announce_category_id;
        $announce['announce_category_name'] = $value->announce_categories->category_name;
        $announce['start_date'] = $value->start_date;
        $announce['end_date'] = $value->end_date;
        $announce['title'] = $value->title;
        $announce['thumbnail_img_path'] = $value->thumbnail_img_path;
        $announce['thumbnail_img_filename'] = $value->thumbnail_img_filename;
        $announce['contents'] = $value->contents;
        $announce['add_account'] = User::find($value->add_account)->name;

        // 対象のお知らせに添付されている画像を取得する
        $records = AnnounceAttachment::where('announce_id', $announceId)
            ->where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->orderBy('id')
            ->get();

        // お知らせ画像 ID
        $announceAttachments = array();
        foreach ($records as $key => $value) {
            $announceAttachment = array();
            $announceAttachment['id'] = $value->id;
            $announceAttachment['shop_id'] = $value->shop_id;
            $announceAttachment['announce_id'] = $value->announce_id;
            $announceAttachment['img_path'] = $value->img_path;
            $announceAttachment['img_filename'] = $value->img_filename;
            $announceAttachments[] = $announceAttachment;
        }

        $response = array();
        $response['announce'] = $announce;
        $response['attachments'] = $announceAttachments;
        return $response;
    }
}
