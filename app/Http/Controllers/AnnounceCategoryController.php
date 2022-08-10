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
        $announceCategories = AnnounceCategory::all();
        $announceCategoryArrays = array();
        foreach ($announceCategories as $key => $value) {
            $announceCategoryArray = array();
            $announceCategoryArray['id'] = $value->id;
            $announceCategoryArray['code'] = $value->code;
            $announceCategoryArray['contract_id'] = $value->contract_id;
            $announceCategoryArray['category'] = $value->category;
            $announceCategoryArray['description'] = $value->description;
            $announceCategoryArray['icon'] = $value->icon;
            $announceCategoryArrays[] = $announceCategoryArray;
        }
        $response['announceCategories'] = $announceCategoryArrays;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}
