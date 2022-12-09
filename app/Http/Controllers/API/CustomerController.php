<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $customers = Customer::all();
        $response = array();
        $customerArrays = array();
        foreach($customers as $key => $value) {
            $customerArray = array();
            $customerArray['id'] = $value->id;
            $customerArray['company_name'] = $value->company_name;
            $customerArrays[] = $customerArray;
        }
        $response['customers'] = $customerArrays;
        // Log::info('取引先取得');
        // Log::debug(print_r($customerArrays, true));
        $response['message'] = 'success';
        return new JsonResponse($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanyBySession(Request $request) {
        $customer = Customer::where('id', Auth::user()->customer_id)->first();
        
        $response = array();
        $response['customer'] = $customer;
        $response['message'] = 'success';
        return new JsonResponse($response);
    }
}
