<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Announce extends Model
{
    use HasFactory;

    protected $table = 'announce';
    protected $fillable = [
        'title',
        'contents',
        'approval_status',
        'approval_comment',
        'approval_account',
        'approval_datetime',
        'del_flg',
    ];

    public function upd_account()
    {
        return $this->belongsTo(User::class, 'upd_account');
    }

    public function announce_category()
    {
        return $this->belongsTo(AnnounceCategory::class);
    }

    public static function getAnnounce($offset, $limit, $sort, $newsStatus, $newsAddAccount, $searchAddDateBegin, $searchAddDateEnd, $searchUpdDateBegin, $searchUpdDateEnd, $searchNewsCol, $searchNews, $searchCategory)
    {
        $announceModel = Announce::with('upd_account', 'announce_category')
            ->where('del_flg', false);

        // 並び順処理
        if ($sort) {
            $announceModel = $announceModel->orderBy($sort);
        } else {
            $announceModel = $announceModel->orderBy('id');
        }

        // 承認済み/承認待ち記事取得
        if ($newsStatus != "") {
            $announceModel = $announceModel->where('approval_status', $newsStatus);
        } else {
            $announceModel = $announceModel->orderBy('id');
        }

        // 自分の投稿記事取得
        if ($newsAddAccount != "") {
            $announceModel = $announceModel->where('add_account', $newsAddAccount);
        } else {
            $announceModel = $announceModel->orderBy('id');
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
        } else {
            $announceModel = $announceModel->orderBy('id');
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
        } else {
            $announceModel = $announceModel->orderBy('id');
        }

        // 検索：登録者・更新者共通
        if ($searchNewsCol != "" && $searchNews != "") {
            $announceModel = $announceModel->where($searchNewsCol, $searchNews);
        } else {
            $announceModel = $announceModel->orderBy('id');
        }

        // 検索：お知らせカテゴリ
        if ($searchCategory) {
            $announceModel = $announceModel->where("announce_category_id", $searchCategory);
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
