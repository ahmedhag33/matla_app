<?php

use App\Http\Controllers\Client\Api\AuthController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::get('generate-password', 'generateStrongPassword');
        // register
        Route::post('register', 'register');
        // login
        Route::post('login', 'login');
        // verify user
        Route::post('verify-user', 'verifyUser')->middleware(['auth.api.user']);
        // get authenticated user
        Route::get('user', 'user')->middleware(['auth.api.user', 'api.user.email.is.not.verify']);
        // logout
        Route::post('logout', 'logout');
        // forget password
        Route::post('forget-password', 'forgetPassword');
        // verify code to reset password
        Route::post('verify-code-to-reset-password', 'verfiyCodeToResetPassword');
        // reset password
        Route::post('reset-password', 'resetPassword');
        // update profile
        Route::post('update', 'updateProfile')->middleware(['auth.api.user', 'api.user.email.is.not.verify']);
        // update photo profile
        Route::post('update/photo', 'updatePhotoProfile')->middleware(['auth.api.user', 'api.user.email.is.not.verify']);
        // update password
        Route::post('update/password', 'updatePassword')->middleware(['auth.api.user', 'api.user.email.is.not.verify']);
        // google login
        Route::post('google', 'googleAuth');
    });
});
