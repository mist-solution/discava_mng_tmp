<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Http\Controllers\API\AuthorityController;

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
        $shop_id = $request->session()->get('shop_id');
        $announce = Announce::getAnnounce($offset, $limit, $sort, $newsStatus, $newsAddAccount, $searchAddDateBegin, $searchAddDateEnd, $searchUpdDateBegin, $searchUpdDateEnd, $searchNewsCol, $searchNews, $searchCategory, $shop_id);
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
    public function approvalAnnounce(announce $announce)
    {
        // 承認ステータスを2:承認済みに更新
        $announce->update(['approval_status' => 2]);
        return $announce;
    }

    // 承認機能（差戻し）
    public function approvalAnnounceReturn(Request $request, Announce $announce)
    {
        // 差戻しコメント
        $approvalReturnComment = $request->input('approvalReturnComment');
        // 承認ステータスを3:差戻しに更新
        $announce->update(['approval_status' => 3]);
        // 差戻しコメント
        $announce->update(['remand_comment' => $approvalReturnComment]);

        return $announce;
    }

    // 承認機能（申請）
    public function request(Announce $announce)
    {
        // 未承認 → 承認
        $announce->update(['approval_status' => 1]);
        return $announce;
    }

    // 承認機能（取り下げ）
    public function cansel(Announce $announce)
    {
        // 未承認 → 承認
        $announce->update(['approval_status' => 0]);
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
        $regist = new Announce();
        $regist['add_account'] = Auth::user()->id;
        $regist['upd_account'] = Auth::user()->id;
        $regist['shop_id'] = $request->session()->get('shop_id');
        $regist['created_at'] = new DateTime();
        $regist['updated_at'] = new DateTime();

        $data = $request->all();
        Log::info('data');
        Log::info(print_r($data, true));
        $announce = json_decode($data['announce'], true);
        Log::info('announce');
        Log::info(print_r($announce, true));
        $thumbnail = $data['thumbnail_file'];
        Log::info('サムネイル');
        Log::info(print_r($thumbnail, true));

        $regist['title'] = $announce['title'];
        $regist['announce_category_id'] = $announce['announce_category_id'];
        $regist['start_date'] = $announce['start_date'];
        $regist['end_date'] = $announce['end_date'];
        $regist['contents'] = $announce['contents'];

        // 登録(1) or 下書き保存(2)
        if ($announce['regist_flg'] == 1) {
            // 登録の場合
            // 承認権限フラグによって登録時の承認ステータスを分ける
            $AuthorityController = new AuthorityController();
            $authorityList = $AuthorityController->getAuthority($request);
            $approvalAuthFlg = $authorityList->original["authority"][0]['approval_auth_flg'];
            $regist['approval_status'] = $approvalAuthFlg = 1 ? 2 : 1;
        } else {
            // 下書き保存の場合
            $regist['approval_status'] = 0;
        }

        $regist->save();

        if ($thumbnail) {
            Log::info('サムネイル アップロード');
            $path = Storage::putFile('announce/'.$regist['shop_id']."/".$regist['id']."/thumbnail", $thumbnail);
            Log::info($path);
            $regist['thumbnail_img_path'] = $path;
            $regist->save();
        }
        return $regist;
    }

    // 更新
    public function update(Request $request, $id)
    {
        $update = [
            'title' => $request->title,
            'announce_category_id' => $request->announce_category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'contents' => $request->contents,
            'upd_account' => Auth::user()->id,
        ];
        $announce = Announce::find($id);
        $announce->update($update);

        Log::info('お知らせ更新');
        Log::debug(print_r($update, true));
    }
}
