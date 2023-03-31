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

        //選択したフォルダから絞り込み（0の場合はすべてのファイルフォルダ）
        if($searchFileID){
            $mediaAttachmentModel = $mediaAttachmentModel->where('media_folder_id',  $searchFileID);
        }

        // 画像キャプション検索
        if ($searchCaption != "") {
            $mediaAttachmentModel = $mediaAttachmentModel->where('img_caption', 'LIKE', "%{$searchCaption}%");
        }

        // 検索：登録日時（開始のみ入力済 、開始/終了入力済）
        if ($searchAddDateBegin) {
            $mediaAttachmentModel = $mediaAttachmentModel
                ->where("created_at", '>=', $searchAddDateBegin)
                ->where("created_at", '<', $searchAddDateEnd);
        }

        //ファイルタイプ絞り込み
        if($searchFileFormat){
            $mediaAttachmentModel = $mediaAttachmentModel
                ->where("img_fileformat",$searchFileFormat);
        }

        return $mediaAttachmentModel;
    }

}
