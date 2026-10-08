<?php

use App\Http\Controllers\Client\Auth\ForgetPasswordController;
use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Auth\SocialiteController;
use App\Http\Controllers\Client\Auth\VerifcationController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\User\UserController;
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

// get index
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index-page');
});
Route::get('/soon', function () {
    return view('errors.soon');
})->name('soon-page');
Route::middleware('redirectToSoon')->group(function () {
    // add all routes here that you want to redirect to soon page
    Route::prefix('client-auth')->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::post('/login', (string) 'login')->name('client-login');
            // add route to logout
            Route::get('/logout', (string) 'logout')->name('client-logout');
        });
        Route::controller(RegisterController::class)->group(function () {
            Route::post('/register', (string) 'register')->name('client-register');
        });
        Route::controller(ForgetPasswordController::class)->group(function () {
            Route::post('/forget-password', (string) 'forget')->name('client-forget-password');
            // add route to send verification code
            Route::post('/verify-code', (string) 'sendCode')->name('client-verify-code');
            // add route to reset password
            Route::post('/reset-password', (string) 'resetPassord')->name('client-reset-password');
        });
    });
    Route::prefix('auth')->group(function () {
        Route::controller(SocialiteController::class)->group(function () {
            Route::get('/{provider}/redirect', (string) 'redirectToProvider')->name('socialite.redirect');
            // add route to callback
            Route::get('/{provider}/callback', (string) 'callback')->name('socialite.callback');
        });
    });
    Route::prefix('user')->middleware('userAuthCheck')->group(function () {
        Route::prefix('verification')->controller(VerifcationController::class)->group(function () {
            // add route to verify email
            Route::post('/verify', (string) 'verify')->name('verification-verify');
            // add route to resend verification code
            Route::get('/resend', (string) 'resend')->name('verification-resend');
        });
        Route::middleware('checkUserISVerify')->group(function () {
            Route::controller(UserController::class)->group(function () {
                // add route to user profile
                Route::get('/profile', (string) 'profile')->name('user.profile');
                // add route to update user photo
                Route::post('/update-photo', (string) 'updatePhoto')->name('user.update-photo');
                // add route to update user profile
                Route::post('/update-profile', (string) 'updateProfile')->name('user.update-profile');
                // add route to update user email
                Route::post('/edit-email', (string) 'editEmail')->name('user.edit-email');
                // add route to update user email
                Route::post('/update-email', (string) 'updateEmail')->name('user.update-email');
                // add route to update user password
                Route::post('/update-password', (string) 'updatePassword')->name('user.update-password');
            });
        });
    });
});
