<?php

use App\Http\Controllers\Workspace\Auth\ForgetPasswordController;
use App\Http\Controllers\Workspace\Auth\LoginController;
use App\Http\Controllers\Workspace\Auth\RegisterController;
use App\Http\Controllers\Workspace\Auth\VerificationController;
use App\Http\Controllers\Workspace\HomeController;
use App\Http\Controllers\Workspace\InventionController;
use App\Http\Controllers\Workspace\MemberController;
use App\Http\Controllers\Workspace\ProgramController;
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
            // add route to invention register form
            Route::get('/invention-register/{token}', 'inventionRegisterForm')->name('workspace.auth.invention-register');
            // add route to invention register form post
            Route::post('/invention-register', 'inventionRegister')->name('workspace.auth.invention-register.post');
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
                // add route to invention verification page
                Route::get('/invention-verify/{token}', 'inventionPage')->name('workspace.auth.invention-verify');
                // add route to handle invention verification
                Route::get('/verify-done/{token}', 'verfiyDone')->name('workspace.auth.verify-done');
            });
        });
        Route::middleware('member-is-not-verfiy')->group(function () {
            // add controller for member
            Route::controller(MemberController::class)->group(function () {
                Route::get('/', 'index')->name('workspace.member.index');
                // add route to accept workspace invitation
                Route::post('/accept-invitation', 'acceptInvitation')->name('workspace.member.accept-invitation');
                // add route to logout
                Route::get('/logout', 'logout')->name('workspace.member.logout');
            });
            Route::controller(WorkspaceController::class)->middleware('check-member-permission:add-workspace')->prefix('create-workspace')->group(function () {
                Route::get('/', 'createPage')->name('workspace.create-workspace.index');
                // add route to handle workspace step
                Route::post('/validate/{step}', 'step')->name('workspace.create-workspace.step');
                // add route to store workspace
                Route::post('/', 'store')->name('workspace.create-workspace.store');
            });
        });
    });
});
Route::prefix('{slug}/workspace')->middleware(['member-not-authenticate', 'member-is-not-verfiy', 'identify-workspace-app', 'check-member-workspace'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('workspace.dashboard.index');
        // add route to mark a notification as read
        Route::post('/read-notification', 'readNotification')->name('workspace.dashboard.read-notification');
    });
    Route::prefix('inventions')->controller(InventionController::class)->group(function () {
        Route::get('/', 'index')->name('workspace.invention.index')
            ->middleware('check-member-permission:invite-members');
        // add route to show invention details
        Route::post('/', 'create')->name('workspace.invention.create')
            ->middleware('check-member-permission:invite-members');
    });
    Route::prefix('programs')->controller(ProgramController::class)->group(function () {
        Route::get('/', 'index')->name('workspace.program.index')
            ->middleware('check-member-permission:view-program');
    });
});
