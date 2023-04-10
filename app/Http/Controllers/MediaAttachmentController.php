<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Storage;

class MediaAttachmentController extends Controller
{
    // 一覧取得
    public function getMediaAttachment(Request $request){


        $searchFileID = $request->input('searchFileID');
        $searchAddDateBegin = $request->input('searchAddDateBegin');
        $searchAddDateEnd = $request->input('searchAddDateEnd');
        $searchFileFormat = $request->input('searchFileFormat');
        $searchCaption = $request->input('searchCaption');
        $shop_id = $request->session()->get('shop_id');

        $mediaAttachment = MediaAttachment::getMediaAttachment($searchFileID, $searchAddDateBegin, $searchAddDateEnd, $searchFileFormat, $searchCaption, $shop_id);


        return $mediaAttachment;

    }

    //画像追加
    public function register(Request $request){
        $regist = new MediaAttachment();
        $regist['add_account'] = Auth::user()->id;
        $regist['upd_account'] = Auth::user()->id;
        $regist['shop_id'] = $request->session()->get('shop_id');
        $regist['created_at'] = new DateTime();
        $regist['updated_at'] = new DateTime();

        $data = $request->all();
        $mediaAttachment = json_decode($data['mediaAttachment'], true);
        $file = $data['file'];

        $regist['media_folder_id'] =  $mediaAttachment['media_folder_id'];
        $regist['img_filename'] =  urldecode($mediaAttachment['img_filename']);
        $regist['img_caption'] =  "";

        $regist['img_fileformat'] = $mediaAttachment['img_fileformat'];
        $regist['img_filesize'] = $mediaAttachment['img_filesize'];
        $regist['img_width'] = 0;
        $regist['img_height'] = 0;
        $regist['img_path'] = "";

        $regist->save();

        $path = Storage::putFile('gallery/' . $regist['shop_id'] . "/" . $regist['id'], $file);
        $regist['img_path'] = $path;

        $regist->save();

        return $regist;

    }

    //削除
    public function delete(Request $request, $id)
    {
        $mediaAttachment =  MediaAttachment::where('id', '=', $id)->firstOrFail();

        $mediaAttachment->update([
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
            'del_flg' => 1
        ]);
    }

    //更新
    public function update(Request $request, $id)
    {
        $mediaAttachment =  MediaAttachment::where('id', '=', $id)->firstOrFail();

        
    }
}