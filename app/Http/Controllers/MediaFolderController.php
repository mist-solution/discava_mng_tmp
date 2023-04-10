<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFolder;
use App\Models\MediaAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use DateTime;
use Storage;

class MediaFolderController extends Controller
{
    //一覧取得
    public function getMediaFolder(Request $request){
        $shopId = $request->session()->get('shop_id');
        $response = array();
        //$searchFolder = $request->input('searchFolder');
        $mediaFolder = MediaFolder::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->get();

        //if ($searchFolder != "") {
        //    $mediaFolder = $mediaFolder->where('parent_folder_id','=','0')
        //    ->where('name', 'LIKE', "%{$searchFolder}%");
        //}

        Log::info($mediaFolder);

        $mediaFolderArrays = array();
        foreach ($mediaFolder as $key => $value) {
            $mediaFolderArray = array();
            $mediaFolderArray['id'] = $value->id;
            $mediaFolderArray['shop_id'] = $value->shop_id;
            $mediaFolderArray['parent_folder_id'] = $value->parent_folder_id;
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
            $mediaFolderArray['isOpen'] = false;
            $mediaFolderArray['isShow'] = false;
            $filecount = MediaAttachment::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->where('media_folder_id', $mediaFolderArray['id'])
            ->get();
            $mediaFolderArray['fileValue'] = count($filecount);
            $mediaFolderArrays[] = $mediaFolderArray;
        }
        $response['mediaFolder'] = $mediaFolderArrays;
        $mibunruicount = MediaAttachment::where('shop_id', $shopId)
        ->where('del_flg', '0')
        ->where('media_folder_id', 1)
        ->get();
        $response['mibunrui'] = count($mibunruicount);
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
        $regist['parent_folder_id'] = $id;

        $data = $request->all();
        $mediaFolder = json_decode($data['mediaFolder'], true);

        // multipart/form-dataだとマルチバイトが文字化けする対応
        // VueでHTMLエンコード→PHPでHTMLデコードする。
        $regist['name'] = urldecode($mediaFolder['name']);

        $regist['media_sort'] = 1;
        $regist['media_width'] = 512;
        $regist['media_height'] = 256;
        $regist['media_column_num'] = 1;
        $regist['media_align'] = 1;
        $regist['media_link'] = 0;
        $regist['media_margin'] = 0;
        $regist['media_caption'] = 0;
        $regist['media_frame_design'] = 0;
        $regist['media_shadow'] = 0;
        $regist['media_hover_expand'] = 1;
        $regist['media_hover_icon'] = 1;
        $regist['media_margin'] = 1;

        $regist->save();

        return $regist;
    }

    //削除
    public function delete(Request $request, $id)
    {
        $mediaFolder =  MediaFolder::where('id', '=', $id)->firstOrFail();

        $mediaFolder->update([
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
            'del_flg' => 1
        ]);

        $mediaAttachment = MediaAttachment::where('media_folder_id', '=', $id);

        foreach ($mediaAttachment as $key => $value) {
            $value['media_folder_id'] = 0;
            $value['upd_account'] = Auth::user()->id;
            $value['updated_at'] = new DateTime();
        }

        return $mediaFolder;
    }

    //名称変更
    public function changeName(Request $request, $id)
    {
        $mediaFolder =  MediaFolder::where('id', '=', $id)->firstOrFail();

        $data = $request->all();
        $mediaFolder2 = json_decode($data['mediaFolder'], true);

        $mediaFolder->update([
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
            'name' => urldecode($mediaFolder2['name'])
        ]);

        return $mediaFolder;
    }
    


}