<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
   {
        $response = array();
        $users = User::all();
        $userArrays = array();
        foreach($users as $key => $value) {
            $customer = $value->customers()->first();
            $userArray = array();
            $userArray['name'] = $value->name;
            $userArray['email'] = $value->email;
            $userArray['customer_code'] = $customer ? $customer->code : null;
            $userArray['created_at'] = $value->created_at;
            $userArray['updated_at'] = $value->updated_at;
            $userArrays[] = $userArray;
        }
        $response['users'] = $userArrays;
        $response['message'] = 'success';
        return new JsonResponse($response);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
