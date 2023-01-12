<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthorityController;
use App\Http\Controllers\API\AuthoritySetController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SelectShopController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\ShopUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnnounceController;
use App\Http\Controllers\AnnounceCategoryController;
use App\Http\Controllers\WebAPI\AnnounceDetailContoller;
use App\Http\Controllers\WebAPI\AnnounceImageController;
use App\Http\Controllers\WebAPI\AnnounceListController;

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

Route::put('/api/changeshop', [SelectShopController::class, 'changeShopId']);

Route::get('/api/shopusers', [ShopUserController::class, 'getLoginUserShopList']);
Route::get('/api/shopselect', [ShopUserController::class, 'getLoginUserShopSelect']);
Route::get('/api/shoplist/{id}', [ShopUserController::class, 'getShopListWithAuthoritySet']);
Route::get('/api/shops', [ShopController::class, 'getShopList']);

Route::get('/api/customer', [CustomerController::class, 'index']);
Route::get('/api/customerSession', [CustomerController::class, 'getCompanyBySession']);

Route::get('/api/enduser', [UserController::class, 'index']);
Route::get('/api/enduser/{id}', [UserController::class, 'showUser']);
Route::post('/api/enduser', [UserController::class, 'register']);
Route::put('/api/enduser/{id}', [UserController::class, 'update']);
Route::post('/api/enduser/delete', [UserController::class, 'deleteAll']);
Route::delete('/api/enduser/{id}', [UserController::class, 'deleteAccount']);
Route::get('/api/loginuserinfo', [UserController::class, 'getUserInfo']);

Route::get('/api/authoritySet', [AuthoritySetController::class, 'getAll']);

Route::get('/api/authority', [AuthorityController::class, 'getAuthority']);

Route::get('/api/announce', [AnnounceController::class, 'getAnnounce']);
Route::get('/api/announce/{announce}', [AnnounceController::class, 'showAnnounce']);
Route::put('/api/announce/{announce}', [AnnounceController::class, 'approvalAllAnnounce']);
Route::put('/api/announce/{announce}/approval', [AnnounceController::class, 'approvalAnnounce']);
Route::put('/api/announce/{announce}/return', [AnnounceController::class, 'approvalAnnounceReturn']);
Route::put('/api/announce/{announce}/reject', [AnnounceController::class, 'approvalAnnounceReject']);
Route::delete('/api/announce/{announce}', [AnnounceController::class, 'deleteAnnounce']);
Route::post('/api/announce', [AnnounceController::class, 'register']);
Route::put('/api/announce/{id}/update', [AnnounceController::class, 'update']);
Route::get('/api/announceCategory', [AnnounceCategoryController::class, 'index']);

//------------------------------------------------
// WebAPI関連
//------------------------------------------------
Route::get('webapi/announce/list', [AnnounceListController::class, 'get']);
Route::get('webapi/announce/detail/{id}', [AnnounceDetailContoller::class, 'get']);
Route::get('webapi/announce/image/{id}', [AnnounceImageController::class, 'get']);