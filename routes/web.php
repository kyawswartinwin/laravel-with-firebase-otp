<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// all this route are for example

Route::get('/register',[AuthController::class, 'registerIndex'])->name('register.index');
Route::post('/register',[AuthController::class, 'registerSubmit'])->name('register.submit');

Route::get('/login',[AuthController::class, 'loginIndex'])->name('login.index');
Route::post('/login',[AuthController::class, 'loginSubmit'])->name('login.submit');

Route::group(['middleware'=>'auth'],function(){
    // you should use different controller
    Route::get('/home',[AuthController::class, 'homeIndex'])->name('home.index');

    Route::get('/otp-verified',[AuthController::class, 'otpVerified'])->name('otp.verified');
});
