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
    Route::get('request_items',                                      [ItemController::class, 'index_for_requests']);
    Route::post('itemlist',                                  [ItemController::class, 'show']);
    Route::post('items',                                     [ItemController::class, 'store']);
    Route::put('items/{item}',                               [ItemController::class, 'update']);
    Route::put('items-comment/{item}',                       [ItemController::class, 'updateComment']);
    Route::delete('items/{item}',                            [ItemController::class, 'destroy']);

    //USER management endpoints
    Route::get('users',                                      [UserController::class, 'index']);
    Route::get('users/{user}',                               [UserController::class, 'show']);
    Route::get('checkuser',                                  [UserController::class, 'check']);
    Route::post('users',                                     [UserController::class, 'store']);
    Route::delete('users/{user}',                            [UserController::class, 'destroy']);
    Route::put('users/{user}',                               [UserController::class, 'update']);

    //STORE management endpoints
    Route::get('stores',                                     [StoreController::class, 'index']);
    Route::get('stores/{store}',                             [StoreController::class, 'show']);
    Route::post('stores',                                    [StoreController::class, 'store']);
    Route::post('add-storekeeper',                           [StoreController::class, 'addStorekeeper']);
    Route::put('delete-storekeeper',                         [StoreController::class, 'deleteStorekeeper']);
    Route::put('migrate-items',                              [StoreController::class, 'migrateItems']);
    Route::delete('stores/{store}',                          [StoreController::class, 'destroy']);

    //REQUEST management endpoints
    Route::get('requests',                                   [RequestController::class, 'index']);
    Route::get('requests/{request}',                         [RequestController::class, 'show']);
    Route::post('requests',                                  [RequestController::class, 'create']);
    Route::put('requests/{request}',                         [RequestController::class, 'update']);
    Route::delete('requests/{request}',                      [RequestController::class, 'destroy']);

    //TAKEOUT management endpoints
    Route::get('takeouts',                                   [TakeOutController::class, 'index']);
    Route::get('takeouts/{takeOut}',                         [TakeOutController::class, 'show']);
    Route::post('takeouts',                                  [TakeOutController::class, 'create']);
    Route::put('takeouts/{takeOut}',                         [TakeOutController::class, 'returnTakeOut']);
});

//Public routes
//USER management endpoints
Route::post('login',                                       [UserController::class, 'login']);
