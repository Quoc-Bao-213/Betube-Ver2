<?php

use App\Http\Controllers\CaregoriesContronller;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VoteController;

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
Route::controller(ResetpasswordController::class)->group(function () {
    Route::get('forgot-password', 'index')->name('forgot-password');
    Route::post('forgot-password', 'resetPassword')->name('action-forgot-password');
    Route::post('link-reset-password', 'sendLinkResetFromGmail')->name('send-link-reset-password');
    Route::post('change-pass', 'processChangePassword');
});

// Home Betube
Route::get('/', [HomeController::class, 'index'])->name('home');

// Index Information User
Route::get('/about-me/{id}', [ProfileController::class, 'show'])->name('about-me');

// Index Changepassword
Route::get('/change-pass', [ProfileController::class, 'indexChangePassword'])->name('change-password');

// Index Video
Route::get('videos/{video}', [VideoController::class, 'show'])->name('video');
Route::post('videos/{video}', [VideoController::class, 'updateViews']);
Route::get('channel/{channel}/videos', [ChannelController::class, 'showVideos'])->name('channel-videos');
Route::get('videos/{video}/comments', [CommentController::class, 'index']);
Route::get('comments/{comment}/replies', [CommentController::class, 'show']);
Route::get('result', [SearchController::class, 'index'])->name('action-search');

// Search Detail Video
Route::get('categories/{categories}', [CaregoriesContronller::class, 'index'])->name('categories');

// Contact
Route::get('contact-us', function () {
    return view('betube.contact');
})->name('contact');

// User
Route::middleware('auth')->group(function () {
    // Action Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('upload-profile/{id}', 'edit')->name('upload-profile');
        Route::post('upload-profile/{id}', 'update')->name('action-upload-profile');
        Route::post('upload-image/{id}', 'uploadAvatar')->name('action-upload-avatar');
        Route::post('upload-image-cover/{id}', 'uploadBackgroundImage')->name('action-upload-cover');
        Route::post('change-pass/{id}', 'changePassword')->name('action-change-password');
        Route::get('subscriptions/{id}', 'getSubscription')->name('subscription');
        Route::get('subscribers/{id}', 'getSubscribers')->name('subscribers');
    });

    // Action Video
    Route::controller(UploadVideoController::class)->group(function () {
        Route::get('upload-video/{channel}/videos', 'index')->name('upload-video');
        Route::post('upload-video/{channel}/videos', 'store')->name('action-upload-video');
        Route::get('update-video/{id}/videos', 'edit')->name('update-video');
        Route::post('update-video/{id}/videos', 'update')->name('action-update-video');
        Route::get('video/{id}/delete', 'destroy')->name('action-delete-video');
    });

    // Action  subscription
    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('channels/{channel}/subscriptions', 'store');
        Route::delete('channels/{channel}/subscriptions/{subscriptions}', 'destroy');
    });

    // Action Like & Dislike
    Route::controller(VoteController::class)->group(function () {
        Route::post('votes/{entityID}/{type}', 'vote');
        Route::delete('votes/{id}/delete', 'deleteVote');
    });

    // Action Comment
    Route::controller(CommentController::class)->group(function () {
        Route::post('comments/{video}', 'store');
        Route::delete('comments/{comment}', 'destroy');
    });

    // Action playlist
    Route::controller(PlaylistController::class)->group(function () {
        Route::get('playlist', 'index')->name('playlist');
        Route::get('user/{id}/playlist', 'getPlaylists');
        Route::get('playlist/{id}', 'show')->name('edit-playlist');
        Route::post('edit-playlist/{id}', 'editPlaylist');
        Route::post('playlist/create', 'create');
        Route::post('playlist/{id}/video/{video}', 'addingToPlaylist');
        Route::post('playlist/{id}/delete', 'deletePlaylist');

        // Playlist Detail
        Route::put('playlist-detail/update', 'updatePlaylistDetail');
        Route::post('playlist-detail/{id}', 'destroy');
    });
    

    Route::get('videos/{video}/list/{playlist}', [VideoController::class, 'showWithPlaylist']);
});