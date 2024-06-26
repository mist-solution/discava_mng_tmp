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
use App\Http\Controllers\MediaFolderController;
use App\Http\Controllers\MediaAttachmentController;
use App\Http\Controllers\WebAPI\AnnounceDetailContoller;
use App\Http\Controllers\WebAPI\AnnounceImageController;
use App\Http\Controllers\WebAPI\AnnounceListController;
use App\Http\Controllers\WebAPI\AnnounceCategoryListController;
use App\Http\Controllers\WebAPI\MediaDetailController;
use App\Http\Controllers\WebAPI\MediaImageController;

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

Route::middleware(['sessionTimeout'])->group(function () {
    // トークンチェック
    Route::get('/api/checkToken', function (Illuminate\Http\Request $request) {
        $request->session()->regenerateToken();
        return response()->json();
    });

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
    Route::get('/api/suggest', [UserController::class, 'suggest']);
    Route::post('/api/enduser', [UserController::class, 'register']);
    Route::put('/api/enduser/{id}', [UserController::class, 'update']);
    Route::post('/api/enduser/delete', [UserController::class, 'deleteAll']);
    Route::delete('/api/enduser/{id}', [UserController::class, 'deleteAccount']);
    Route::put('/api/enduser/updateAuthority/{id}/{No}', [UserController::class, 'updateAuthority']);
    // アカウント新規登録のバリデーションAPI
    Route::post('/api/enduser/registValidation', [UserController::class, 'registStore']);
    // アカウント編集のバリデーションAPI
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
    Route::get('/api/announce/{id}', [AnnounceController::class, 'showAnnounce']);
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
    Route::post('/api/announce/{id}/update', [AnnounceController::class, 'update']);
    // 申請
    Route::put('/api/announce/{announce}/request', [AnnounceController::class, 'request']);
    // 取り下げる
    Route::put('/api/announce/{announce}/cansel', [AnnounceController::class, 'cansel']);
    Route::get('/api/announceCategory', [AnnounceCategoryController::class, 'index']);

    Route::get('/api/oldestAnnounce', [AnnounceController::class, 'oldestAnnounce']);

    // お知らせ新規登録のバリデーションAPI
    Route::post('/api/announce/registValidation', [AnnounceController::class, 'registStore']);
    // お知らせ新規編集のバリデーションAPI
    Route::post('/api/announce/tempValidation', [AnnounceController::class, 'tempStore']);

    //------------------------------------------------
    // メディア編集関連
    //------------------------------------------------
    // フォルダ一覧取得
    Route::get('/api/mediafolder', [MediaFolderController::class, 'getMediaFolder']);
    // フォルダ一覧取得(ギャラリーを作成した)
    Route::get('/api/mediafolder/getGallery/{id}', [MediaFolderController::class, 'getGallery']);
    // フォルダ新規作成
    Route::post('/api/mediafolder/register/{id}', [MediaFolderController::class, 'register']);
    // フォルダ削除
    Route::delete('/api/mediafolder/{id}', [MediaFolderController::class, 'delete']);
    //フォルダ名称変更
    Route::post('/api/mediafolder/namechange/{id}', [MediaFolderController::class, 'changeName']);
    //フォルダソート1
    Route::get('/api/mediafolder/asc', [MediaFolderController::class, 'getSortMediaFolder1']);
    //フォルダソート2
    Route::get('/api/mediafolder/desc', [MediaFolderController::class, 'getSortMediaFolder2']);
    // フォルダ詳細取得
    Route::get('/api/mediafolder/{id}', [MediaFolderController::class, 'ShowMediaFolder']);
    // 編集
    Route::post('/api/mediafolder/{id}/update', [MediaFolderController::class, 'update']);


    //画像一覧取得
    Route::get('/api/mediaAttachment', [MediaAttachmentController::class, 'getMediaAttachment']);
    //画像取得
    Route::get('/api/mediaAttachment/{id}', [MediaAttachmentController::class, 'get']);
    //画像追加
    Route::post('/api/mediaAttachment/register', [MediaAttachmentController::class, 'register']);
    //画像削除
    Route::delete('/api/mediaAttachment/delete/{id}', [MediaAttachmentController::class, 'delete']);
    //画像更新
    Route::post('/api/mediaAttachment/update/{id}', [MediaAttachmentController::class, 'update']);
});


//------------------------------------------------
// WebAPI関連
//------------------------------------------------
Route::get('webapi/announce/list', [AnnounceListController::class, 'get']);
Route::get('webapi/announce/detail/{id}', [AnnounceDetailContoller::class, 'get']);
Route::get('webapi/announce/image/{id}', [AnnounceImageController::class, 'get']);
Route::get('webapi/announce/categoryList', [AnnounceCategoryListController::class, 'get']);

//------------------------------------------------
// メディアWebAPI関連
//------------------------------------------------
Route::get('webapi/media/detail/{id}', [MediaDetailController::class, 'get']);
Route::get('webapi/media/image/{id}', [MediaImageController::class, 'get']);
Route::post('webapi/media/imageSort/{id}', [MediaDetailController::class, 'setImageSort']);
