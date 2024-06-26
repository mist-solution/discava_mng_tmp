<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Http\Controllers\API\AuthorityController;
use App\Models\AnnounceAttachment;
use App\Http\Requests\AnnounceRegistRequest;
use App\Http\Requests\AnnounceTempRequest;

class AnnounceController extends Controller
{
    // 一覧取得
    public function getAnnounce(Request $request)
    {
        Log::info('一覧取得');

        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $sort = $request->input('sort');
        $announceStatus = $request->input('announceStatus');
        $announceAddAccount = $request->input('announceAddAccount');
        $searchAddDateBegin = $request->input('searchAddDateBegin');
        $searchAddDateEnd = $request->input('searchAddDateEnd');
        $searchUpdDateBegin = $request->input('searchUpdDateBegin');
        $searchUpdDateEnd = $request->input('searchUpdDateEnd');
        $searchAnnounceCol = $request->input('searchAnnounceCol');
        $searchAnnounce = $request->input('searchAnnounce');
        $searchCategory = $request->input('searchCategory');
        $searchRelease = $request->input('searchRelease');
        $shop_id = $request->session()->get('shop_id');
        $announce = Announce::getAnnounce($offset, $limit, $sort, $announceStatus, $announceAddAccount, $searchAddDateBegin, $searchAddDateEnd, $searchUpdDateBegin, $searchUpdDateEnd, $searchAnnounceCol, $searchAnnounce, $searchCategory, $searchRelease, $shop_id);
        foreach ($announce["anounce"] as $key => $value) {
            if ($value["thumbnail_img_path"]) {
                $thumbnail_img_contents = Storage::get($value["thumbnail_img_path"]);
                $thumbnail_img_base64 = base64_encode($thumbnail_img_contents);
                $value["thumbnail_img_path"] = $thumbnail_img_base64;
            }
        }
        return $announce;
    }


    // 詳細取得
    public function showAnnounce($id)
    {
        $announce =  Announce::with('attachments')->where('id', '=', $id)->firstOrFail();
        Log::info('詳細取得');

        // 有効フラグ判断
        if ($announce->del_flg == 1) {
            return 1;

            // 否認されたお知らせ判断
        } else if ($announce->approval_status == 9) {
            return 9;
        }

        // 添付ファイルを取得
        if (!is_null($announce['attachments'])) {
            foreach ($announce['attachments'] as $key => $value) {
                if ($value['img_path']) {
                    $attachments_img = Storage::get($value['img_path']);
                    $attachments_img_base64 = base64_encode($attachments_img);
                    $value['img_file'] = $attachments_img_base64;
                }
            }
            Log::info($announce['attachments']);
        }

        if ($announce->thumbnail_img_path) {
            $thumbnail_img_contents = Storage::get($announce->thumbnail_img_path);
            $thumbnail_img_base64 = base64_encode($thumbnail_img_contents);
            $announce->thumbnail_img_path = $thumbnail_img_base64;
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
        // 承認ステータスを2:承認済み、承認アカウントを更新
        $announce->update([
            'approval_status' => 2,
            'approval_account' => Auth::user()->id,
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
        ]);
        return $announce;
    }

    // 承認機能（差戻し）
    public function approvalAnnounceReturn(Request $request, Announce $announce)
    {
        // 差戻しコメント
        $approvalReturnComment = $request->input('approvalReturnComment');
        // 承認ステータスを3:差戻し、差戻しコメントを更新
        $announce->update([
            'remand_comment' => $approvalReturnComment,
            'approval_status' => 3,
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
        ]);

        return $announce;
    }

    // 承認機能（申請）
    public function request(Announce $announce)
    {
        // 未承認 → 承認
        $announce->update([
            'approval_status' => 1,
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime()
        ]);
        return $announce;
    }

    // 承認機能（取り下げ）
    public function cansel(Announce $announce)
    {
        $announce->update([
            'approval_status' => 0,
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
        ]);
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
        $announce->update([
            'upd_account' => Auth::user()->id,
            'updated_at' => new DateTime(),
            'del_flg' => 1
        ]);
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
        $thumbnail = null;
        if (array_key_exists('thumbnail_file', $data)) {
            $thumbnail = $data['thumbnail_file'];
            Log::info('サムネイル');
            Log::info(print_r($thumbnail, true));
        }
        $attachments = [];
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
        }
        Log::info('ファイル');
        Log::info(print_r($attachments, true));

        // multipart/form-dataだとマルチバイトが文字化けする対応
        // VueでHTMLエンコード→PHPでHTMLデコードする。
        $regist['title'] = urldecode($announce['title']);
        $regist['announce_category_id'] = $announce['announce_category_id'];
        $regist['start_date'] = $announce['start_date'];
        $regist['end_date'] = $announce['end_date'];
        $regist['contents'] = urldecode($announce['contents']);

        // 登録(1) or 下書き保存(2)
        if ($announce['regist_flg'] == 1) {
            // 登録の場合
            // 承認権限フラグによって登録時の承認ステータスを分ける
            $AuthorityController = new AuthorityController();
            $authorityList = $AuthorityController->getAuthority($request);
            $approvalAuthFlg = $authorityList->original["authority"][0]['approval_auth_flg'];
            $regist['approval_status'] = $approvalAuthFlg == 1 ? 2 : 1;
        } else {
            // 下書き保存の場合
            $regist['approval_status'] = 0;
        }

        $regist->save();

        if ($thumbnail) {
            Log::info('サムネイル アップロード');
            $path = Storage::putFile('announce/' . $regist['shop_id'] . "/" . $regist['id'] . "/thumbnail", $thumbnail);
            Log::info($path);
            $regist['thumbnail_img_path'] = $path;
            $regist->save();
        }

        foreach ($attachments as $key => $value) {
            Log::info('ファイル アップロード');
            Log::info(print_r($key, true));
            Log::info(print_r($value, true));

            $path = Storage::putFile('announce/' . $regist['shop_id'] . "/" . $regist['id'] . "/attachments", $value);
            Log::info($path);

            $attach = new AnnounceAttachment();
            $attach->shop_id = $regist->shop_id;
            $attach->announce_id = $regist->id;
            $attach->img_filename = $value->getClientOriginalName();
            $attach->img_path = $path;
            $attach->add_account = Auth::user()->id;
            $attach->upd_account = Auth::user()->id;
            $attach->del_flg = false;

            $attach->save();
        }


        return $regist;
    }

    // 更新
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Log::info('data');
        Log::info(print_r($data, true));
        $announce = json_decode($data['announce'], true);
        Log::info('announce');
        Log::info(print_r($announce, true));
        $thumbnail = null;
        if (array_key_exists('thumbnail_file', $data)) {
            $thumbnail = $data['thumbnail_file'];
            Log::info('サムネイル');
            Log::info(print_r($thumbnail, true));
        }
        $insertAttachments = [];
        if (array_key_exists('insertAttachments', $data)) {
            $insertAttachments = $data['insertAttachments'];
        }
        Log::info('追加ファイル');
        Log::info(print_r($insertAttachments, true));
        $deleteAttachments = [];
        if (array_key_exists('deleteAttachments', $data)) {
            $deleteAttachments = $data['deleteAttachments'];
        }
        Log::info('削除ファイル');
        Log::info(print_r($deleteAttachments, true));

        if ($thumbnail) {
            $update = [
                'title' => urldecode($announce['title']),
                'announce_category_id' => $announce['announce_category_id'],
                'start_date' => $announce['start_date'],
                'end_date' => $announce['end_date'],
                'contents' => urldecode($announce['contents']),
                'upd_account' => Auth::user()->id,
                'thumbnail_img_path' => Storage::putFile('announce/' . $request->session()->get('shop_id') . "/" . $id . "/thumbnail", $thumbnail),
            ];
        } else {
            $update = [
                'title' => urldecode($announce['title']),
                'announce_category_id' => $announce['announce_category_id'],
                'start_date' => $announce['start_date'],
                'end_date' => $announce['end_date'],
                'contents' => urldecode($announce['contents']),
                'upd_account' => Auth::user()->id,
            ];
        }
        $model = Announce::find($id);
        $model->update($update);

        foreach ($insertAttachments as $key => $value) {
            Log::info('ファイル アップロード');
            Log::info(print_r($key, true));
            Log::info(print_r($value, true));

            $path = Storage::putFile('announce/' . $model->shop_id . "/" . $model->id . "/attachments", $value);
            Log::info($path);

            $attach = new AnnounceAttachment();
            $attach->shop_id = $model->shop_id;
            $attach->announce_id = $model->id;
            $attach->img_filename = $value->getClientOriginalName();
            $attach->img_path = $path;
            $attach->add_account = Auth::user()->id;
            $attach->upd_account = Auth::user()->id;
            $attach->del_flg = false;

            $attach->save();
        }

        foreach ($deleteAttachments as $key => $value) {
            $deleteAttachment = json_decode($value, true);
            Log::info('ファイル 削除');
            Log::info(print_r($key, true));
            Log::info(print_r($value, true));
            Log::info(print_r($deleteAttachment, true));

            $fileDelete = Storage::delete($deleteAttachment["img_path"]);
            Log::info($fileDelete);

            $dbDelete = AnnounceAttachment::where('id', $deleteAttachment["id"])->delete();
            Log::info($dbDelete);
        }

        Log::info('お知らせ更新');
        Log::debug(print_r($model, true));
    }

    public function oldestAnnounce(Request $request)
    {
        $shop_id = $request->session()->get('shop_id');
        $oldestData = Announce::getOldestTime($shop_id);
        return $oldestData;
    }

    // バリデーションリクエスト(お知らせ登録)
    public function registStore(AnnounceRegistRequest $request)
    {
        if (!$request->validated()) {
            return redirect()->back()->withInput()->withErrors($request->errors());
        }
    }

    // バリデーションリクエスト(お知らせ下書き)
    public function tempStore(AnnounceTempRequest $request)
    {
        if (!$request->validated()) {
            return redirect()->back()->withInput()->withErrors($request->errors());
        }
    }
}
