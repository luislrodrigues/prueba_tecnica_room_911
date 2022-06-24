<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Livewire\User\User;
use App\Http\Livewire\Employee\Employee;
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

Route::controller(LoginController::class)->group(function(){
    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login');
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function(){
    Route::get('/user',User::class)->middleware('role')->name('user');
    Route::get('/employee',Employee::class)->name('employee');
    Route::get('history/pdf',[Employee::class, 'historyPDF'])->name('pdf');
});