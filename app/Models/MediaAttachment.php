<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class MediaAttachment extends Model
{
    use HasFactory;

    protected $table = 'media_attachments';
    
    protected $fillable = [
        'shop_id',
        'media_folder_id',
        'img_path',
        'img_filename',
        'img_fileformat',
        'img_filesize',
        'img_height',
        'img_width',
        'img_caption',
        'img_memo',
        'img_alt',
        'img_sortno',
        'add_account',
        'upd_account',
        'del_flg',
    ];

    public function media_folders()
    {
        return $this->belongsTo(MediaFolder::class, 'media_folder_id');
    }

    public function add_account()
    {
        return $this->belongsTo(User::class, 'add_account');
    }

    //一覧取得
    public static function getMediaAttachment($searchFileID, $searchAddDateBegin, $searchAddDateEnd, $searchFileFormat, $searchCaption, $shop_id)
    {
        $mediaAttachmentModel = MediaAttachment::with('add_account')
            ->where('del_flg', false)
            ->where('shop_id', $shop_id);

        //選択したフォルダから絞り込み（-1の場合はすべてのファイルフォルダ）
        if($searchFileID != "" && $searchFileID != "-1" && $searchFileID != "0"){
            $mediaAttachmentModel = $mediaAttachmentModel->where('media_folder_id',  $searchFileID);
        }else if($searchFileID == "0"){
            $mediaAttachmentModel = $mediaAttachmentModel->where('media_folder_id',  1);
        }

        $mediaAttachment['mediaAttachment'] = $mediaAttachmentModel
            ->get();


        // 画像検索
        if ($searchCaption != "") {
            $pat = '%' . addcslashes($searchCaption, '%_\\') . '%';
            $mediaAttachmentModel = $mediaAttachmentModel->where(function ($query) use ($pat) {
                $query->orwhere('img_caption', 'LIKE', $pat)
                    ->orwhere('img_filename', 'LIKE', $pat)
                    ->orwhere('img_alt', 'LIKE', $pat)
                    ->orwhere('img_memo', 'LIKE', $pat);
            });
        }

        // 検索：登録日時
        if ($searchAddDateBegin) {
            $mediaAttachmentModel = $mediaAttachmentModel
                ->where("created_at", '>=', $searchAddDateBegin)
                ->where("created_at", '<', $searchAddDateEnd);
        }

        //ファイルタイプ絞り込み
        if($searchFileFormat){
            if($searchFileFormat == 1){
                $mediaAttachmentModel = $mediaAttachmentModel
                ->where("img_fileformat",'LIKE',"%image%");
            }else if($searchFileFormat == 2){
                $mediaAttachmentModel = $mediaAttachmentModel
                ->where("img_fileformat","movie/mp4");
            }else if($searchFileFormat == 3){
                $mediaAttachmentModel = $mediaAttachmentModel
                ->where("img_fileformat","audio/wav");
            }else if($searchFileFormat == 4){
                $mediaAttachmentModel = $mediaAttachmentModel
                ->where("img_fileformat","text/txt");
            }
        }

        $mediaAttachment['count'] = $mediaAttachmentModel
            ->count();

        $mediaAttachment['mediaAttachment'] = $mediaAttachmentModel
            ->get();

        return $mediaAttachment;
    }

}
