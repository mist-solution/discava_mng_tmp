<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
}