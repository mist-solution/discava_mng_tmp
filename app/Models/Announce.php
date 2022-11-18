<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Announce extends Model
{
    use HasFactory;

    protected $table = 'announces';

    protected $fillable = [
        'shop_id',
        'announce_category_id',
        'start_date',
        'end_date',
        'title',
        'thumbnail_img_path',
        'contents',
        'approval_status',
        'approval_account',
        'approval_datetime',
        'remand_comment',
        'add_account',
        'upd_account',
        'del_flg',
    ];

    public function add_account()
    {
        return $this->belongsTo(User::class, 'add_account');
    }

    public function upd_account()
    {
        return $this->belongsTo(User::class, 'upd_account');
    }

    public function announce_category()
    {
        return $this->belongsTo(AnnounceCategory::class, 'announce_category_id');
    }

    public static function getAnnounce($offset, $limit, $sort, $newsStatus, $newsAddAccount, $searchAddDateBegin, $searchAddDateEnd, $searchUpdDateBegin, $searchUpdDateEnd, $searchNewsCol, $searchNews, $searchCategory)
    {
        $announceModel = Announce::with('add_account', 'upd_account', 'announce_category')->where('del_flg', false);

        // 承認済み/承認待ち記事取得
        if ($newsStatus != "") {
            // 表示条件：承認待ち
            if ($newsStatus == 1) {
                $announceModel = $announceModel->where('approval_status', $newsStatus);
            // 表示条件：承認済
            } else if ($newsStatus == 2) {
                $announceModel = $announceModel->where('approval_status', $newsStatus);
            }
            // 表示条件：全ては条件追加しない
        }

        // 自分の投稿記事取得
        if ($newsAddAccount != "") {
            $announceModel = $announceModel->where('add_account', $newsAddAccount);
        }

        // 検索：登録日時（開始のみ入力済 、開始/終了入力済）
        if ($searchAddDateBegin) {
            if ($searchAddDateEnd) {
                $announceModel = $announceModel
                    ->where("created_at", '>=', $searchAddDateBegin)
                    ->where("created_at", '<=', $searchAddDateEnd);
            }
            $announceModel = $announceModel
                ->where("created_at", '>=', $searchAddDateBegin);
        }

        // 検索：更新日時（開始のみ入力済 、開始/終了入力済）
        if ($searchUpdDateBegin) {
            if ($searchUpdDateEnd) {
                $announceModel = $announceModel
                    ->where("updated_at", '>=', $searchUpdDateBegin)
                    ->where("updated_at", '<=', $searchUpdDateEnd);
            }
            $announceModel = $announceModel
                ->where("updated_at", '>=', $searchUpdDateBegin);
        }

        // 検索：登録者・更新者共通
        if ($searchNewsCol != "" && $searchNews != "") {
            $announceModel = $announceModel->where($searchNewsCol, $searchNews);
        }

        // 検索：お知らせカテゴリ
        if ($searchCategory) {
            $announceModel = $announceModel->where("announce_category_id", $searchCategory);
        }

        // 並び順処理
        if ($sort) {
            if (strpos($sort, "_desc") == false) {
                $announceModel = $announceModel->orderBy($sort);
            } else {
                $sort =  str_replace("_desc", "", $sort);
                $announceModel = $announceModel->orderBy($sort, 'desc');
            }
        } else {
            $announceModel = $announceModel->orderBy('id');
        }
        
        $announce['count'] = $announceModel
            ->count();

        $announce['anounce'] = $announceModel
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $announce;
    }
}
