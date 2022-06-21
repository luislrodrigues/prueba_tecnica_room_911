<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('auth.login');
// });


Route::controller(LoginController::class)->group(function(){
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login');
    Route::post('logout', 'logout')->name('logout');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
