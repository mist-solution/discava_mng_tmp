<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Authority;

class AuthorityController extends Controller
{
    //対象ユーザーの詳細な権限情報を取得
    public function getAuthority(request $request)
    {
        $authoritySetId = $request->session()->get('authority_set_id');
        $response = array();
        
        $shopUserAuthority = Authority::where('mate_function_id','1')
            ->where('authority_set_id',$authoritySetId)
            ->where('del_flg','0')
            ->get();
        
        $authorityArray = array();
        foreach ($shopUserAuthority as $key => $value) {
            $authorityData = array();
            $authorityData['authority_set_id'] = $value->authority_set_id;
            $authorityData['mate_function_id'] = $value->mate_function_id;
            $authorityData['function_auth_flg'] = $value->function_auth_flg;
            $authorityData['create_auth_flg'] = $value->create_auth_flg;
            $authorityData['read_auth_flg'] = $value->read_auth_flg;
            $authorityData['update_auth_flg'] = $value->update_auth_flg;
            $authorityData['delete_auth_flg'] = $value->delete_auth_flg;
            $authorityData['request_auth_flg'] = $value->request_auth_flg;
            $authorityData['approval_auth_flg'] = $value->approval_auth_flg;
            $authorityArray[] = $authorityData;
        }
        
        $response['authority'] = $authorityArray;
        $response['message'] = 'success_au';
        return new JsonResponse($response);
    }

}
