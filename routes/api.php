<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);

Route::group(['middleware'=>['auth:api','checkExpirt']],function(){
    Route::get('dates',[DateController::class,'dates']);
    Route::post('create',[ExpertiseController::class,'create']);
    Route::post('create1',[DateController::class,'create1']);
});

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('details/{ex_id}',[ExpertiseController::class,'details']);
    Route::get('reserve/{date_id}',[DateController::class,'reserve']);
    Route::post('logout',[UserController::class,'logout']);
    Route::get('list/{id}',[ExpertiseController::class,'list']);
    Route::get('delete/{ex_id}',[ExpertiseController::class,'delete']);
    Route::get('coins',[UserController::class,'coins']);
    Route::get('time/{id}/{day}',[DateController::class,'time']);
    Route::get('addFavorite/{ex_id}',[FavoriteController::class,'addFavorite']);
    Route::get('showFavorite',[FavoriteController::class,'showFavorite']);
    Route::get('search/{name}',[ExpertiseController::class,'search']);
});
