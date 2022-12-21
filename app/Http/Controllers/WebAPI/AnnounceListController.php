<?php

namespace App\Http\Controllers\WebAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class AnnounceListController extends Controller
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
            "list" => [
                [ "id" => "1", "title" => "タイトル(1)です。", "thumbnail_img" => "sample1.png" ],
                [ "id" => "2", "title" => "タイトル(2)です。", "thumbnail_img" => "sample2.png" ],
                [ "id" => "3", "title" => "タイトル(3)です。", "thumbnail_img" => "sample3.png" ],
            ],
            "result" => "success",
        ]);
    }
}

