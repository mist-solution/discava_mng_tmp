<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class AnnounceDetailContoller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * 
     *
     * @return response
     */
    public function post(Request $request)
    {
        return response([
            "title" => "タイトルです。",
            "body" => "<div>記事詳細です。</div>",
            "result" => "success",
        ]);
    }
}

