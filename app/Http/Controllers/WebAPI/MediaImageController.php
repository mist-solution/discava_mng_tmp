<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaAttachment;
use App\Models\MediaFolder;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Storage;
use DateTime;

class MediaImageController extends Controller
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
        $mediaAttachmentId = null;
        $mediaFolderId = null;
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

        if (is_null($id)) {
            return response()->json([
                'message' => 'Internal Server Error(not found image id by token[' . $token . '])'
            ], 500);
        }

        // メディアファイルの取得
        $mediaImageId = $id;
        // 対象のお知らせに添付されている画像を取得する
        $record = MediaAttachment::where('id', $mediaImageId)
            ->where('shop_id', $shopId)
            ->whereHas('media_folders', function ($query) {
                $query->where('del_flg', '0');
            })
            ->where('del_flg', '0')
            ->first();
        if (is_null($record)) {
            return response()->json([
                'message' => 'Internal Server Error(not found shop\'s media record)'
            ], 404);
        }

        // メディア添付画像
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

        log::info(response($binary)->header('Content-Type', $mimeType));
        return response($binary)->header('Content-Type', $mimeType);
    }
}
