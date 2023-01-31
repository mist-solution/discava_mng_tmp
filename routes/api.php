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
Route::get('/api/shopusers/{id}', [ShopController::class, 'getShopUserList']);

Route::get('/api/customer', [CustomerController::class, 'index']);
Route::get('/api/customerSession', [CustomerController::class, 'getCompanyBySession']);

Route::get('/api/enduser', [UserController::class, 'index']);
Route::get('/api/enduser/{id}', [UserController::class, 'showUser']);
Route::post('/api/enduser', [UserController::class, 'register']);
Route::put('/api/enduser/{id}', [UserController::class, 'update']);
Route::post('/api/enduser/delete', [UserController::class, 'deleteAll']);
Route::delete('/api/enduser/{id}', [UserController::class, 'deleteAccount']);
// アカウント新規登録・編集のバリデーションAPI
Route::post('/api/enduser/registValidation', [UserController::class, 'registStore']);
Route::post('/api/enduser/updateValidation', [UserController::class, 'updateStore']);

Route::get('/api/loginuserinfo', [UserController::class, 'getUserInfo']);

Route::get('/api/authoritySet', [AuthoritySetController::class, 'getAll']);

Route::get('/api/authority', [AuthorityController::class, 'getAuthority']);

//------------------------------------------------
// お知らせ関連
//------------------------------------------------
// 一覧取得
Route::get('/api/announce', [AnnounceController::class, 'getAnnounce']);
// 詳細取得
Route::get('/api/announce/{announce}', [AnnounceController::class, 'showAnnounce']);
// 一括承認
Route::put('/api/announce/{announce}', [AnnounceController::class, 'approvalAllAnnounce']);
// 承認する
Route::post('/api/announce/{announce}/approval', [AnnounceController::class, 'approvalAnnounce']);
// 差戻し
Route::put('/api/announce/{announce}/return', [AnnounceController::class, 'approvalAnnounceReturn']);
// 削除
Route::delete('/api/announce/{announce}', [AnnounceController::class, 'deleteAnnounce']);
// 新規登録
Route::post('/api/announce/regist', [AnnounceController::class, 'register']);
// 編集
Route::put('/api/announce/{id}/update', [AnnounceController::class, 'update']);
// 申請
Route::put('/api/announce/{announce}/request', [AnnounceController::class, 'request']);
// 取り下げる
Route::put('/api/announce/{announce}/cansel', [AnnounceController::class, 'cansel']);
Route::get('/api/announceCategory', [AnnounceCategoryController::class, 'index']);

Route::get('/api/oldestAnnounce', [AnnounceController::class, 'oldestAnnounce']);

// お知らせ新規登録・編集のバリデーションAPI
Route::post('/api/announce/validation', [AnnounceController::class, 'store']);

//------------------------------------------------
// WebAPI関連
//------------------------------------------------
Route::get('webapi/announce/list', [AnnounceListController::class, 'get']);
Route::get('webapi/announce/detail/{id}', [AnnounceDetailContoller::class, 'get']);
Route::get('webapi/announce/image/{id}', [AnnounceImageController::class, 'get']);
