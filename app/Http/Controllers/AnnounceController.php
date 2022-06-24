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
        return $announce;
    }

    // 一括承認
    public function acceptAllAnnounce(Request $request, Announce $announce)
    {
        $announce->update(['approval_status' => 1]);
        return $announce;
    }
}
