<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\Auth\RegisterController;

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
Route::get('/announce/{announce}', 'AnnounceController@showAnnounce');
Route::put('/announce/{announce}', 'AnnounceController@acceptAllAnnounce');
Route::delete('/announce/{announce}', 'AnnounceController@deleteAnnounce');
Route::get('/enduser', [UserController::class, 'index']);
Route::get('/customer', [CustomerController::class, 'index']);
Route::post('/enduser', [RegisterController::class, 'register']);
Route::put('/enduser/{id}', [UserController::class, 'update']);
Route::post('/enduser/delete', [UserController::class, 'deleteAll']);
Route::get('/announceCategory', 'AnnounceCategoryController@index');
