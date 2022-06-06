<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;
use Illuminate\Support\Facades\Log;

class AnnounceController extends Controller
{
    //
    public function getAnnounce(Request $request)
    {
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $announce = Announce::getAnnounce($offset, $limit);
        return $announce;
    }

    // 並び順
    public function getAnnounceSort(Request $request)
    {
        $sort = $request->input('sort');
        $announce = Announce::getAnnounceSort($sort);
        return $announce;
    }
}
