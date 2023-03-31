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

        $regist['media_folder_id'] =  $mediaAttachment['media_folder_id'];
        $regist['img_filename'] =  urldecode($mediaAttachment['img_filename']);
        $regist['img_caption'] =  urldecode($mediaAttachment['img_caption']);
        $regist['img_memo'] =  urldecode($mediaAttachment['img_memo']);
        $regist['img_alt'] =  urldecode($mediaAttachment['img_alt']);


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