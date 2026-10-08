<?php

use App\Http\Controllers\Dashboard\Auth\LoginController;
use App\Http\Controllers\Dashboard\Auth\RecoverPasswordController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
// login routes
Route::controller(LoginController::class)->group(function () {
    Route::middleware(['adminIsAuthticate'])->group(function () {
        Route::get('login', 'showLoginForm')->name('dashboard.auth.login');
        // add route to login
        Route::post('login', 'login')->name('dashboard.auth.login.post');
    });
    Route::middleware(['checkAdminIsAuthticate'])->group(function () {
        // add route to logout
        Route::get('logout', 'logout')->name('dashboard.auth.logout');
    });
});
Route::middleware(['checkAdminIsAuthticate'])->group(function () {
    // recover password routes
    Route::middleware(['adminPasswordIsChange'])
        ->controller(RecoverPasswordController::class)->group(function () {
            Route::get('recover-password', 'recoverPasswordPage')->name('dashboard.auth.recover-password');
            // add route to recover password
            Route::post('recover-password', 'recoverPassword')->name('dashboard.auth.recover-password.post');
        });
    Route::middleware(['adminPasswordIsNotChange'])->group(function () {
        // dashboard routes
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.index');
        });
        Route::prefix('roles')->controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.role.index');
        });
        Route::prefix('users')->controller(UsersController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard.user.index');
        });
    });
});
