<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;
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
        $announce = Announce::getAnnounce($offset, $limit, $sort, $newsStatus, $newsAddAccount);
        return $announce;
    }

    // 詳細取得
    public function showAnnounce(Announce $announce)
    {
        return $announce;
    }

    // 一括承認
    public function acceptAllAnnounce(Request $request, Announce $announce)
    {
        $announce->update(['approval_status' => 1]);
        return $announce;
    }
}
