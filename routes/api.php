<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Born\BornBrowseController;
use App\Http\Controllers\Comer\ComerBrowseController;
use App\Http\Controllers\Dead\DeadBrowseController;
use App\Http\Controllers\Family\FamilyBrowseController;
use App\Http\Controllers\Family\FamilyController;
use App\Http\Controllers\Move\MoveBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\User\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("user/insert", [UserController::class,"Insert"])->middleware('UserInsert');
Route::put("user/update/{id}", [UserController::class,"Update"])->middleware('UserUpdate');
Route::delete("user/delete/{id}", [UserController::class,"Delete"])->middleware('UserDelete');

Route::post("family/insert", [FamilyController::class,"Insert"])->middleware('FamilyInsert');
Route::put("family/update/{id}", [FamilyController::class,"Update"])->middleware('FamilyUpdate');
Route::delete("family/delete/{id}", [FamilyController::class,"Delete"])->middleware('FamilyDelete');



Route::post("get_born", [BornBrowseController::class,"Anything"]);
Route::post("get_comer", [ComerBrowseController::class,"Anything"]);
Route::post("get_dead", [DeadBrowseController::class,"Anything"]);
Route::post("get_family", [FamilyBrowseController::class,"Anything"]);
Route::post("get_move", [MoveBrowseController::class,"Anything"]);
Route::post("get_position", [PositionBrowseController::class,"Anything"]);
Route::post("get_user", [UserBrowseController::class,"Anything"]);

