<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\AnnounceAttachment;
use App\Models\Shop;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Log;

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

        $currentTime = date('Y-m-d H:i:s');
        log::info("currentTime 0");
        log::info($currentTime);

        // ヘッダーのX-DiscavaMATE-API-Tokenを取得
        $token = $request->header('X-DiscavaMATE-API-Token');
        if (is_null($token)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        log::info("currentTime Img 1");
        log::info($currentTime);

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
                'message' => 'Internal Server Error'
            ], 500);
        }

        log::info("currentTime Img 2");
        log::info($currentTime);

        // 店舗の指定されたお知らせIDを取得
        $announceAttachmentId = $id;
        if (is_null($announceAttachmentId)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        log::info("currentTime Img 3");
        log::info($currentTime);

        // 対象のお知らせに添付されている画像を取得する
        $record = AnnounceAttachment::where('id', $announceAttachmentId)
            ->where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->first();
        if (is_null($record)) {
            return response()->json([
                'message' => 'Internal Server Error'
            ], 500);
        }

        log::info("currentTime Img 4");
        log::info($currentTime);

        // お知らせ画像 ID
        $filePath = $record->img_path;
        $fileName = $record->img_filename;
        $binary = Storage::disk()->get($filePath);
        $mimeType = Storage::disk()->mimeType($filePath);
        if (is_null($binary)) {
            return response()->json([
                'message' => 'Internal Server Error',
                'filepath' => $filePath,
                'filename' => $fileName,
                'mimetype' => $mimeType,
            ], 500);
        }

        log::info("currentTime Img 5");
        log::info($currentTime);

        return response($binary)->header('Content-Type', $mimeType);
    }
}
