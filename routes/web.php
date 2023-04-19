<?php

use App\Http\Controllers\SetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;

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

Route::redirect('/', 'login');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'isAdmin'], function () {
        // User endpoints
        Route::get('users',                                  [UserController::class, 'index'])->name('users');
        Route::delete('user_destroy/{user}',                 [UserController::class, 'destroy'])->name('user_destroy');
        Route::post('user_store',                            [UserController::class, 'store'])->name('user_store');

        //Store endpoints
        Route::get('stores',                                 [StoreController::class, 'index'])->name('stores');
        Route::delete('store_destroy/{store}',               [StoreController::class, 'destroy'])->name('store_destroy');
        Route::post('store_store',                           [StoreController::class, 'store'])->name('store_store');
    });

    Route::get('setpassword',                           [SetPasswordController::class, 'create'])->name('setpassword');
    Route::post('setpassword',                          [SetPasswordController::class, 'store'])->name('setpassword_store');

    Route::get('/no_access', function () {
        return view('no_access');
    })->name('no_access');
});

Route::get('invitation/{user}',                     [UserController::class, 'invitation'])->name('invitation');
require __DIR__ . '/auth.php';
