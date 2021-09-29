<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin group routes
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'],function () {
        Route::view('login','admin.login')->name('admin.login');
        Route::post('login',[AdminController::class,'login'])->name('admin.auth');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::view('dashboard','admin.home')->name('admin.home');
        Route::post('logout',[AdminController::class,'logout'])->name('admin.logout');
    });
});