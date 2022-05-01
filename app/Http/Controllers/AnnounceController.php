<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announce;

class AnnounceController extends Controller
{
    //
    public function getAnnounce(Request $request) {
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $announce = Announce::getAnnounce($offset, $limit);
        return $announce;
    }
}
