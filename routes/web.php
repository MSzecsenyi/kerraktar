<?php

use App\Http\Controllers\SetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
        Route::get('users',                                      [UserController::class, 'index'])->name('users');
        Route::get('user_create',                                [UserController::class, 'create'])->name('user_create');
        Route::delete('user_destroy/{user}',                     [UserController::class, 'destroy'])->name('user_destroy');
        Route::post('user_store',                                [UserController::class, 'store'])->name('user_store');
        // Route::resource('users', UserController::class);
    });

    Route::get('setpassword',                               [SetPasswordController::class, 'create'])->name('setpassword');
    Route::post('setpassword',                              [SetPasswordController::class, 'store'])->name('setpassword_store');

    Route::get('/no_access', function () {
        return view('no_access');
    })->name('no_access');
});

Route::get('invitation/{user}',                         [UserController::class, 'invitation'])->name('invitation');


require __DIR__ . '/auth.php';
