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
    public function getMediaFolder(Request $request)
    {
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
            $mediaFolderArray['kaisou'] = $value->kaisou;
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
        $regist['kaisou'] = $mediaFolder['kaisou'];

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
        $regist['media_hover_expand'] = 0;
        $regist['media_hover_icon'] = 0;

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

        $shop_id = $request->session()->get('shop_id');

        $mediaAttachment = MediaAttachment::getMediaAttachment($id, null, null, null, null, $shop_id);


        foreach ($mediaAttachment["mediaAttachment"] as $key => $value) {
            $value->update([
                'media_folder_id' => 1,
                'upd_account' => Auth::user()->id,
                'updated_at' => new DateTime()
            ]);
        }

        return $mediaFolder;

        return $mediaAttachment;
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

    //名前を降順で取得
    public function getSortMediaFolder2(Request $request)
    {
        $shopId = $request->session()->get('shop_id');
        $response = array();
        //$searchFolder = $request->input('searchFolder');
        $mediaFolder = MediaFolder::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->orderBy('name', 'desc')
            ->get();

        //if ($searchFolder != "") {
        //    $mediaFolder = $mediaFolder->where('parent_folder_id','=','0')
        //    ->where('name', 'LIKE', "%{$searchFolder}%");
        //}

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
            $mediaFolderArray['kaisou'] = $value->kaisou;
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

    //名前を昇順で取得
    public function getSortMediaFolder1(Request $request)
    {
        $shopId = $request->session()->get('shop_id');
        $response = array();
        //$searchFolder = $request->input('searchFolder');
        $mediaFolder = MediaFolder::where('shop_id', $shopId)
            ->where('del_flg', '0')
            ->orderBy('name', 'asc')
            ->get();

        //if ($searchFolder != "") {
        //    $mediaFolder = $mediaFolder->where('parent_folder_id','=','0')
        //    ->where('name', 'LIKE', "%{$searchFolder}%");
        //}

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
            $mediaFolderArray['kaisou'] = $value->kaisou;
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

    //詳細取得
    public function ShowMediaFolder($id)
    {
        $mediaFolder =  MediaFolder::where('id', '=', $id)->firstOrFail();
        log::info($id);
        return $mediaFolder;
    }

    // ギャラリー内容を取得
    public function getGallery($id)
    {
        // ソートした画像配列のJSONファイルを取得
        if (Storage::exists('gallery/galleryBySortJson/' . $id . '/galleryArraysBySorted.json')) {
            $getJsonFile = Storage::get('gallery/galleryBySortJson/' . $id . '/galleryArraysBySorted.json');
            $getGalleryJson = json_decode($getJsonFile, true);
            $galleryArrays = $getGalleryJson;
            return $galleryArrays;
        } else {
            return response()->json([
                'message' => 'Json file is not exist.'
            ], 404);
        }
    }

    // 更新
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $mediaFolder = json_decode($data['mediafolder'], true);
        $update = [
            'media_width' => $mediaFolder['media_width'],
            'media_height' => $mediaFolder['media_height'],
            'media_sort' => $mediaFolder['media_sort'],
            'media_align' => $mediaFolder['media_align'],
            'media_frame_color' => urldecode($mediaFolder['media_frame_color']),
            'media_frame_design' => $mediaFolder['media_frame_design'],
            'media_column_num' => $mediaFolder['media_column_num'],
            'media_link' => $mediaFolder['media_link'],
            'media_link_url' => urldecode($mediaFolder['media_link_url']),
            'media_margin' => $mediaFolder['media_margin'],
            'media_caption' => $mediaFolder['media_caption'],
            'media_shadow' => $mediaFolder['media_shadow'],
            'media_hover_expand' => $mediaFolder['media_hover_expand'],
            'media_hover_icon' => $mediaFolder['media_hover_icon'],
            'upd_account' => Auth::user()->id,
        ];
        $model = MediaFolder::find($id);
        $model->update($update);
    }
}
