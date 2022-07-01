<?php

namespace App\Http\Controllers;

use App\Models\AnnounceCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnounceCategoryController extends Controller
{
    // 一覧取得
    public function index(Request $request)
    {
        $response = array();
        $announceCategorys = AnnounceCategory::all();
        $announceCategoryArrays = array();
        foreach ($announceCategorys as $key => $value) {
            $announceCategoryArray = array();
            $announceCategoryArray['code'] = $value->code;
            $announceCategoryArray['contract_id'] = $value->contract_id;
            $announceCategoryArray['category'] = $value->category;
            $announceCategoryArray['description'] = $value->description;
            $announceCategoryArray['icon'] = $value->icon;
            $announceCategoryArrays[] = $announceCategoryArray;
        }
        $response['announceCategorys'] = $announceCategoryArrays;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}
