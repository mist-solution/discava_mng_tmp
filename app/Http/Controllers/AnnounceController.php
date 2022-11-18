<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;
use DateTime;
use Illuminate\Support\Facades\Log;

class AnnounceController extends Controller
{
    // 一覧取得
    public function getAnnounce(Request $request)
    {
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $sort = $request->input('sort');
        $newsStatus = $request->input('newsStatus');
        $newsAddAccount = $request->input('newsAddAccount');
        $searchAddDateBegin = $request->input('searchAddDateBegin');
        $searchAddDateEnd = $request->input('searchAddDateEnd');
        $searchUpdDateBegin = $request->input('searchUpdDateBegin');
        $searchUpdDateEnd = $request->input('searchUpdDateEnd');
        $searchNewsCol = $request->input('searchNewsCol');
        $searchNews = $request->input('searchNews');
        $searchCategory = $request->input('searchCategory');
        $announce = Announce::getAnnounce($offset, $limit, $sort, $newsStatus, $newsAddAccount, $searchAddDateBegin, $searchAddDateEnd, $searchUpdDateBegin, $searchUpdDateEnd, $searchNewsCol, $searchNews, $searchCategory);
        return $announce;
    }

    // 詳細取得
    public function showAnnounce(Announce $announce)
    {
        // 有効フラグ判断
        if ($announce->del_flg == 1) {
            return 1;

            // 否認されたお知らせ判断
        } else if ($announce->approval_status == 9) {
            return 9;
        }
        return $announce;
    }

    // 承認機能（一括承認）
    public function approvalAllAnnounce(Request $request, Announce $announce)
    {
        $announce->update(['approval_status' => 1]);
        return $announce;
    }
    // 承認機能（承認）
    public function approvalAnnounce(Request $request, Announce $announce)
    {
        // 未承認 → 承認
        if ($announce['approval_status'] == 0) {
            $announce->update(['approval_status' => 1]);
            log::info("ID:  " . $announce['id'] . ":::未承認 → 承認:::  " . $announce['approval_status']);

            // 差戻し → 承認
        } else if (($announce['approval_status'] == 2)) {
            $announce->update(['approval_status' => 1]);
            log::info("ID:  " . $announce['id'] . ":::差戻し → 承認:::  " . $announce['approval_status']);
        }
        return $announce;
    }

    // 承認機能（差戻し）
    public function approvalAnnounceReturn(Request $request, Announce $announce)
    {
        $approvalReturnComment = $request->input('approvalReturnComment');
        // 未承認 → 差戻し
        if ($announce['approval_status'] == 0) {
            $announce->update(['approval_status' => 2]);
            $announce->update(['remand_comment' => $approvalReturnComment]);
            log::info("ID:  " . $announce['id'] . ":::未承認 → 再差戻し:::  " . $announce['approval_status'] . "  comment:: " . $announce['remand_comment']);

            // 差戻し → 再差戻し
        } else if ($announce['approval_status'] == 2) {
            $announce->update(['remand_comment' => $approvalReturnComment]);
            $announce->update(['approval_status' => 2]);
            log::info("ID:  " . $announce['id'] . ":::差戻し → 再差戻し:::  " . $announce['approval_status'] . "  comment:: " . $announce['remand_comment']);
        }
        return $announce;
    }

    // 承認機能（否認）
    public function approvalAnnounceReject(Request $request, Announce $announce)
    {
        // 未承認 → 承認
        $announce->update(['approval_status' => 9]);
        log::info("ID:  " . $announce['id'] . ":::否認されました:::  " . $announce['approval_status']);
        return $announce;
    }

    // お知らせ論理削除
    public function deleteAnnounce(Announce $announce)
    {
        $announce->update(['del_flg' => 1]);
        return $announce;
    }

    // 新規
    public function register(Request $request)
    {
        $announce = new Announce();
        $announce['add_account'] = 1;
        $announce['upd_account'] = 1;
        $announce['shop_id'] = 1;
        $announce['created_at'] = new DateTime();
        $announce['updated_at'] = new DateTime();

        $data = $request->all();
        $announce['title'] = $data['title'];
        $announce['announce_category_id'] = $data['announce_category_id'];
        $announce['start_date'] = $data['start_date'];
        $announce['end_date'] = $data['end_date'];
        $announce['contents'] = $data['contents'];

        $announce->save();
        return $announce;
    }
}
