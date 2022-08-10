<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\HomeController;

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

// Register
Route::get('register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'register'])->name('actionRegister');

// Login
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->name('actionLogin');

// Logout
Route::post('logout', [LoginController::class, 'logout'])->name('actionLogout');

// Forgot Password
Route::get('forgot-password', [ResetpasswordController::class, 'index'])->name('forgot-password');
Route::post('forgot-password', [ResetpasswordController::class, 'resetPassword'])->name('action-forgot-password');
Route::post('link-reset-password', [ResetpasswordController::class, 'sendLinkResetFromGmail'])->name('send-link-reset-password');
Route::post('change-pass', [ResetpasswordController::class, 'processChangePassword']);

// Home Betube
Route::get('/', [HomeController::class, 'index'])->name('home');

// // Index Information User
// Route::get('/about-me/{id}','ProfileController@show')->name('about-me');

// // Index Changepassword
// Route::get('/change-pass','ProfileController@indexChangePassword')->name('change-password');

// // Index Video
// Route::get('videos/{video}', 'VideoController@show')->name('video');
// Route::post('videos/{video}', 'VideoController@updateViews');
// Route::get('channel/{channel}/videos', 'ChannelController@showVideos')->name('channel-videos');
// Route::get('videos/{video}/comments', 'CommentController@index');
// Route::get('comments/{comment}/replies', 'CommentController@show');
// Route::get('result', 'SearchController@index')->name('action-search');