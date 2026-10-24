<?php

use App\Http\Controllers\Workspace\Auth\ForgetPasswordController;
use App\Http\Controllers\Workspace\Auth\LoginController;
use App\Http\Controllers\Workspace\Auth\RegisterController;
use App\Http\Controllers\Workspace\Auth\VerificationController;
use App\Http\Controllers\Workspace\HomeController;
use App\Http\Controllers\Workspace\MemberController;
use App\Http\Controllers\Workspace\WorkspaceController;
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

Route::prefix('member')->group(function () {
    Route::middleware('member-is-authenticate')->group(function () {
        // add controller for auth
        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'index')->name('workspace.auth.login');
            // add route to login
            Route::post('/login', 'login')->name('workspace.auth.login.post');
        });
        Route::controller(RegisterController::class)->group(function () {
            Route::get('/register', 'index')->name('workspace.auth.register');
            // add route to register
            Route::post('/register', 'register')->name('workspace.auth.register.post');
        });
        Route::controller(ForgetPasswordController::class)->group(function () {
            Route::get('/forget-password', 'forgetPage')->name('workspace.auth.forget-password');
            // add route to forget password
            Route::post('/forget-password', 'forget')->name('workspace.auth.forget-password.post');
            // add route to forget password
            Route::get('/verify-password', 'verifyPage')
                ->middleware('ensure-verification-code-sent')
                ->name('workspace.auth.verify-password');
            // add route to forget password
            Route::post('/verify-password', 'verify')->name('workspace.auth.verify-password.post');
            // add route to reset password
            Route::get('/reset-password', 'resetPasswordPage')
                ->middleware('ensure-verification-code-sent')
                ->name('workspace.auth.reset-password');
            // add route to reset password
            Route::post('/reset-password', 'resetPassord')->name('workspace.auth.reset-password.post');
        });
    });
    Route::middleware('member-not-authenticate')->group(function () {
        Route::prefix('verification')->middleware('member-is-verfiy')->group(function () {
            Route::controller(VerificationController::class)->group(function () {
                // add route to verify email
                Route::get('/', 'index')->name('workspace.verification.index');
                // add route to verify email
                Route::post('/verify', 'verify')->name('workspace.verification.verify');
                // add route to resend verification code
                Route::get('/resend', 'resend')->name('workspace.verification.resend');
            });
        });
        Route::middleware('member-is-not-verfiy')->group(function () {
            // add controller for member
            Route::controller(MemberController::class)->group(function () {
                Route::get('/', 'index')->name('workspace.member.index');
                // add route to logout
                Route::get('/logout', 'logout')->name('workspace.member.logout');
            });
            Route::controller(WorkspaceController::class)->prefix('create-workspace')->group(function () {
                Route::get('/', 'createPage')->name('workspace.create-workspace.index');
                // add route to handle workspace step
                Route::post('/validate/{step}', 'step')->name('workspace.create-workspace.step');
                // add route to store workspace
                Route::post('/', 'store')->name('workspace.create-workspace.store');
            });
        });
    });
});
Route::prefix('{slug}/workspace')->middleware(['member-not-authenticate', 'member-is-not-verfiy', 'identify-workspace-app'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('workspace.dashboard.index');
    });
});
