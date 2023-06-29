<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\AnnounceAttachment;
use App\Models\Shop;
use Illuminate\Http\Request;
use Storage;

class AnnounceImageController extends Controller
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
    public function get(Request $request, $id)
    {
        $token = null;
        $shopId = null;
        $announceAttachmentId = null;
        $response = array();

        // ヘッダーのX-DiscavaMATE-API-Tokenを取得
        $token = $request->header('X-DiscavaMATE-API-Token');
        if (is_null($token)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        // 合致するtokenから店舗を取得
        // $records = Shop::all();
        // $response = array();
        // foreach($records as $key => $value) {
        //     if ($token == $value->webapi_token) {
        //         $shopId = $value->id;
        //         break;
        //     }
        // }
        // if(is_null($shopId)) {
        //     return response()->json([
        //         'message' => 'Internal Server Error'
        //     ], 500);
        // }

        // 店舗の指定されたお知らせIDを取得
        // $announceAttachmentId = $id;
        // if (is_null($announceAttachmentId)) {
        //     return response()->json([
        //         'message' => 'Internal Server Error'
        //     ], 500);
        // }

        // 対象のお知らせに添付されている画像を取得する
        // $record = AnnounceAttachment::where('id', $announceAttachmentId)
        //     ->where('shop_id', $shopId)
        //     ->where('del_flg', '0')
        //     ->first();
        // if (is_null($record)) {
        //     return response()->json([
        //         'message' => 'Internal Server Error'
        //     ], 500);
        // }
        $shop = Shop::where('webapi_token', $token)->first();
        if (is_null($shop)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        $record = AnnounceAttachment::with('shop')
            ->where('id', $id)
            ->where('shop_id', $shop->id)
            ->where('del_flg', '0')
            ->first();

        if (is_null($record)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        // お知らせ画像 ID
        // $filePath = $record->img_path;
        // $fileName = $record->img_filename;
        // $binary = Storage::disk()->get($filePath);
        // $mimeType = Storage::disk()->mimeType($filePath);

        $binary = Storage::disk()->get($record->img_path);
        $mimeType = Storage::disk()->mimeType($record->img_path);

        if (is_null($binary)) {
            return response()->json([
                'message' => 'Internal Server Error',
                'filepath' => $record->img_path,
                'filename' => $record->img_filename,
                'mimetype' => $mimeType,
            ], 500);
        }

        return response($binary)->header('Content-Type', $mimeType);
}
