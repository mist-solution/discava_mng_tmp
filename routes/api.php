<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EndUserController;
use App\Http\Controllers\API\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/tasks', 'TaskController@index');
Route::post('/tasks', 'TaskController@store');
Route::get('/tasks/{task}', 'TaskController@show');
Route::put('/tasks/{task}', 'TaskController@update');
Route::delete('/tasks/{task}', 'TaskController@destroy');
Route::get('/announce', 'AnnounceController@getAnnounce');
Route::get('/enduser', [EndUserController::class, 'index']);
Route::get('/customer', [CustomerController::class, 'index']);
