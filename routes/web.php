<?php

use App\Http\Controllers\Link\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Born\BornBrowseController;
use App\Http\Controllers\Comer\ComerBrowseController;
use App\Http\Controllers\Dead\DeadBrowseController;
use App\Http\Controllers\Family\FamilyBrowseController;
use App\Http\Controllers\Move\MoveBrowseController;
use App\Http\Controllers\Position\PositionBrowseController;
use App\Http\Controllers\User\UserBrowseController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post("get_born", [BornBrowseController::class,"Anything"])->name('GetBorn');
Route::post("get_comer", [ComerBrowseController::class,"Anything"])->name('GetComer');
Route::post("get_dead", [DeadBrowseController::class,"Anything"])->name('GetDead');
Route::post("get_family", [FamilyBrowseController::class,"Anything"])->name('GetFamily');
Route::post("get_move", [MoveBrowseController::class,"Anything"])->name('GetMove');
Route::post("get_position", [PositionBrowseController::class,"Anything"]);
Route::post("get_user", [UserBrowseController::class,"Anything"])->name('GetUser');

Route::post("user/insert", [UserController::class,"Insert"])->name('UserInsert');

Route::get("/", [LinkController::class,"Anything"])->middleware('link');
Route::get("/{query}", [LinkController::class,"Anything"])->where('query', '.+')->middleware('link');
