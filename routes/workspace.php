<?php

use App\Http\Controllers\Client\Auth\VerifcationController;
use App\Http\Controllers\Workspace\Auth\LoginController;
use App\Http\Controllers\Workspace\Auth\RegisterController;
use App\Http\Controllers\Workspace\HomeController;
use App\Http\Controllers\Workspace\MemberController;
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
        });
        Route::controller(RegisterController::class)->group(function () {
            Route::get('/register', 'index')->name('workspace.auth.register');
        });
    });
    Route::middleware('member-not-authenticate')->group(function () {
        Route::prefix('verification')->middleware('member-is-verfiy')->group(function () {
            Route::controller(VerifcationController::class)->group(function () {
                // add route to verify email
                Route::get('/', 'index')->name('workspace.verification.index');
            });
        });
        Route::middleware('member-is-not-verfiy')->group(function () {
            // add controller for member
            Route::controller(MemberController::class)->group(function () {
                Route::get('/', 'index')->name('workspace.member.index');
            });
        });
    });
});
Route::prefix('workspace')->middleware(['member-is-authenticate', 'member-is-not-verfiy'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('workspace.dashboard.index');
    });
});
