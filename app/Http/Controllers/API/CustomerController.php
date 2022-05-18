<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request) {

        $customers = Customer::all();
        $response = array();
        $customerArrays = array();
        foreach($customers as $key => $value) {
            $customerArray = array();
            $customerArray['code'] = $value->code;
            $customerArray['company_name'] = $value->company_name;
            $customerArrays[] = $customerArray;
        }
        $response['customers'] = $customerArrays;
        Log::info('取引先取得');
        Log::debug(print_r($customerArrays, true));
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}
