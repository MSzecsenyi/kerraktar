<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TakeOutController;
use App\Http\Controllers\UserController;
use Facade\FlareClient\Context\RequestContext;
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


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout',                                   [UserController::class, 'logout']);
    Route::post('logoutall',                                [UserController::class, 'logoutAll']);

    //ITEM management endpoints
    Route::get('items',                                      [ItemController::class, 'index']);
    Route::post('itemlist',                                  [ItemController::class, 'show']);
    Route::post('items',                                     [ItemController::class, 'store']);
    Route::put('items/{item}',                               [ItemController::class, 'update']);
    Route::delete('items/{item}',                            [ItemController::class, 'destroy']);
    Route::put('items-comment/{item}',                       [ItemController::class, 'updateComment']);

    //USER management endpoints
    Route::get('users',                                      [UserController::class, 'index']);
    Route::get('users/{user}',                               [UserController::class, 'show']);
    Route::post('users',                                     [UserController::class, 'store']);
    Route::put('users/{user}',                               [UserController::class, 'update']);
    Route::delete('users/{user}',                            [UserController::class, 'destroy']);
    Route::get('checkuser',                                  [UserController::class, 'check']);

    //STORE management endpoints
    Route::get('stores',                                     [StoreController::class, 'index']);
    Route::get('stores/{store}',                             [StoreController::class, 'show']);
    Route::post('stores',                                    [StoreController::class, 'store']);
    Route::delete('stores/{store}',                          [StoreController::class, 'destroy']);
    Route::post('add-storekeeper',                           [StoreController::class, 'addStorekeeper']);
    Route::put('delete-storekeeper',                         [StoreController::class, 'deleteStorekeeper']);
    Route::put('migrate-items',                              [StoreController::class, 'migrateItems']);

    //REQUEST management endpoints
    Route::get('requests',                                   [RequestController::class, 'index']);
    Route::post('requests',                                  [RequestController::class, 'create']);
    Route::get('requests/{request}',                         [RequestController::class, 'show']);
    Route::put('requests/{request}',                         [RequestController::class, 'update']);

    //TAKEOUT management endpoints
    Route::post('takeouts',                                  [TakeOutController::class, 'create']);
    Route::get('takeouts',                                   [TakeOutController::class, 'index']);
    Route::get('takeouts/{takeOut}',                         [TakeOutController::class, 'show']);
    Route::put('takeouts/{takeOut}',                         [TakeOutController::class, 'returnTakeOut']);
});

//Public routes
//USER management endpoints
Route::post('login',                                       [UserController::class, 'login']);
