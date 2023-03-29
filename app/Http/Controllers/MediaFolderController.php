<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFolder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Storage;

class MediaFolderController extends Controller
{
    //一覧取得
    public function getMediaFolder(Request $request){
        $shopId = $request->session()->get('shop_id');
        $response = array();
        $mediaFolder = MediaFolder::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->get();

        $mediaFolderArrays = array();
        foreach ($mediaFolder as $key => $value) {
            $mediaFolderArray = array();
            $mediaFolderArray['id'] = $value->id;
            $mediaFolderArray['shop_id'] = $value->shop_id;
            $mediaFolderArray['name'] = $value->name;
            $mediaFolderArray['media_sort'] = $value->media_sort;
            $mediaFolderArray['media_width'] = $value->media_width;
            $mediaFolderArray['media_height'] = $value->media_height;
            $mediaFolderArray['media_column_num'] = $value->media_column_num;
            $mediaFolderArray['media_align'] = $value->media_align;
            $mediaFolderArray['media_link'] = $value->media_link;
            $mediaFolderArray['media_margin'] = $value->media_margin;
            $mediaFolderArray['media_caption'] = $value->media_caption;
            $mediaFolderArray['media_frame_design'] = $value->media_frame_design;
            $mediaFolderArray['media_frame_color'] = $value->media_frame_color;
            $mediaFolderArray['media_shadow'] = $value->media_shadow;
            $mediaFolderArray['media_hover_expand'] = $value->media_hover_expand;
            $mediaFolderArray['media_hover_icon'] = $value->media_hover_icon;
            $mediaFolderArray['add_account'] = $value->add_account;
            $mediaFolderArrays[] = $mediaFolderArray;
        }
        $response['mediaFolder'] = $mediaFolderArrays;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

    //追加
    public function register(Request $request, $id)
    {
        $regist = new MediaFolder();
        $regist['add_account'] = Auth::user()->id;
        $regist['upd_account'] = Auth::user()->id;
        $regist['shop_id'] = $request->session()->get('shop_id');
        $regist['created_at'] = new DateTime();
        $regist['updated_at'] = new DateTime();

        return $regist;
    }
    //削除

    //名称変更


}