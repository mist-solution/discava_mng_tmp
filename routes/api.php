<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\AnnounceCategoryController;

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

//Route::get('/api/tasks', 'TaskController@index');
//Route::post('/api/tasks', 'TaskController@store');
//Route::get('/api/tasks/{task}', 'TaskController@show');
//Route::put('/api/tasks/{task}', 'TaskController@update');
//Route::delete('/api/tasks/{task}', 'TaskController@destroy');

Route::get('/api/customer', [CustomerController::class, 'index']);
Route::get('/api/enduser', [UserController::class, 'index']);
Route::post('/api/enduser', [RegisterController::class, 'register']);
Route::put('/api/enduser/{id}', [UserController::class, 'update']);
Route::post('/api/enduser/delete', [UserController::class, 'deleteAll']);

// ログイン済みの場合のみに使用するAPI
Route::group(['middleware' => 'auth'], function () {
    Route::get('/api/announce', 'AnnounceController@getAnnounce');
    Route::get('/api/announce/{announce}', 'AnnounceController@showAnnounce');
    Route::put('/api/announce/{announce}', 'AnnounceController@approvalAllAnnounce');
    Route::put('/api/announce/{announce}/approval', 'AnnounceController@approvalAnnounce');
    Route::put('/api/announce/{announce}/return', 'AnnounceController@approvalAnnounceReturn');
    Route::put('/api/announce/{announce}/reject', 'AnnounceController@approvalAnnounceReject');
    Route::delete('/api/announce/{announce}', 'AnnounceController@deleteAnnounce');
    Route::post('/api/announce', [AnnounceController::class, 'register']);
    Route::get('/api/announceCategory', [AnnounceCategoryController::class, 'index']);
});
