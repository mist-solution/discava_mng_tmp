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

class MediaDetailController extends Controller
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
                'message' => 'Internal Server Error(not found shop id by token[' . $token . '])'
            ], 500);
        }

        // メディアフォルダの取得
        $mediaFolderId = $id;
        $mediaFolderValue = MediaFolder::where('id', $mediaFolderId)
            ->where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->first();
        if (is_null($mediaFolderValue)) {
            return response()->json([
                'message' => 'Internal Server Error(not found shop\'s media record)'
            ], 404);
        }

        // メディア詳細
        $media = array();
        $media['id'] = $mediaFolderValue->id;
        $media['shop_id'] = $mediaFolderValue->shop_id;
        $media['media_sort'] = $mediaFolderValue->media_sort;
        $media['media_width'] = $mediaFolderValue->media_width;
        $media['media_height'] = $mediaFolderValue->media_height;
        $media['media_column_num'] = $mediaFolderValue->media_column_num;
        $media['media_align'] = $mediaFolderValue->media_align;
        $media['media_link'] = $mediaFolderValue->media_link;
        $media['media_link_url'] = $mediaFolderValue->media_link_url;
        $media['media_margin'] = $mediaFolderValue->media_margin;
        $media['media_caption'] = $mediaFolderValue->media_caption;
        $media['media_frame_design'] = $mediaFolderValue->media_frame_design;
        $media['media_frame_color'] = $mediaFolderValue->media_frame_color;
        $media['media_shadow'] = $mediaFolderValue->media_shadow;
        $media['media_hover_expand'] = $mediaFolderValue->media_hover_expand;
        $media['media_hover_icon'] = $mediaFolderValue->media_hover_icon;


        // 対象のメディアフォルダに添付されているメディア画像を取得する
        $records = MediaAttachment::where('media_folder_id', $mediaFolderId)
            ->where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->orderBy('id')
            ->get();

        if (is_null($records)) {
            return response()->json([
                'message' => 'Internal Server Error(not found shop\'s media record)'
            ], 404);
        }

        // メディア添付画像
        $mediaAttachments = array();
        foreach ($records as $key => $value) {
            $mediaAttachment = array();
            $mediaAttachment['id'] = $value->id;
            $mediaAttachment['shop_id'] = $value->shop_id;
            $mediaAttachment['media_folder_id'] = $value->media_folder_id;
            $mediaAttachment['img_path'] = $value->img_path;
            $mediaAttachment['img_filename'] = $value->img_filename;
            $mediaAttachment['img_fileformat'] = $value->img_fileformat;
            $mediaAttachment['img_height'] = $value->img_height;
            $mediaAttachment['img_width'] = $value->img_width;
            $mediaAttachment['img_caption'] = $value->img_caption;
            $mediaAttachment['img_memo'] = $value->img_memo;
            $mediaAttachment['img_alt'] = $value->img_alt;
            $mediaAttachment['img_sortno'] = $value->img_sortno;
            $mediaAttachments[] = $mediaAttachment;
        }
        $response = array();
        $response['media'] = $media;
        $response['mediaAttachments'] = $mediaAttachments;

        return $response;
    }
}
