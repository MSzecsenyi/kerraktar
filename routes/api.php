<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//ITEM management endpoints
Route::get      ('items',                       [ItemController::class, 'index']);
Route::get      ('items/{item}',                [ItemController::class, 'show']);
Route::post     ('items',                       [ItemController::class, 'store']);
Route::put      ('items/{item}',                [ItemController::class, 'update']);
Route::delete   ('items/{item}',                [ItemController::class, 'destroy']);

//USER management endpoints
Route::get      ('users',                       [UserController::class, 'index']);
Route::get      ('users/{user}',                [UserController::class, 'show']);
Route::post     ('users',                       [UserController::class, 'store']);
Route::put      ('users/{user}',                [UserController::class, 'update']);
Route::delete   ('users/{user}',                [UserController::class, 'destroy']);

//STORE management endpoints
Route::get      ('stores',                      [StoreController::class, 'index']);
Route::get      ('stores/{store}',              [StoreController::class, 'show']);
Route::post     ('stores',                      [StoreController::class, 'store']);
Route::delete   ('stores/{store}',              [StoreController::class, 'destroy']);
Route::post     ('add-storekeeper',             [StoreController::class, 'addStorekeeper']);
Route::put      ('delete-storekeeper',          [StoreController::class, 'deleteStorekeeper']);
Route::put      ('migrate-items',               [StoreController::class, 'migrateItems']);

//REQUEST management endpoints
Route::post     ('requests',                    [RequestController::class, 'store']);
Route::patch    ('accept-requests/{request}',   [RequestController::class, 'acceptRequest']);
Route::get      ('requests',                    [RequestController::class, 'index']);
