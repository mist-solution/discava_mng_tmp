<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\AuthoritySet;

class AuthoritySetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request) {

        $records = AuthoritySet::all();
        $response = array();
        $authoritySetArrays = array();
        foreach($records as $key => $value) {
            $authoritySetArray = array();
            $authoritySetArray['id'] = $value->id;
            $authoritySetArray['name'] = $value->name;
            $authoritySetArrays[] = $authoritySetArray;
        }
        $response['customers'] = $authoritySetArrays;
        // Log::info('取引先取得');
        // Log::debug(print_r($authoritySetArrays, true));
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

}
