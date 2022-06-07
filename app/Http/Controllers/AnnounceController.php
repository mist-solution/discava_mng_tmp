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
        $sort = $request->input('sort');
        $announce = Announce::getAnnounce($offset, $limit, $sort);
        return $announce;
    }
}
