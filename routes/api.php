<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
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

/**
 * Actions Handled By Resource Controller
 * Verb	        URI	                    Action	        Route Name
 * GET	        /photos	                index	        photos.index
 * POST	        /photos	                store	        photos.store
 * GET	        /photos/{photo}	        show	        photos.show
 * PUT/PATCH	/photos/{photo}	        update	        photos.update
 * DELETE	    /photos/{photo}	        destroy	        photos.destroy
 */

//////////////////////////////////////////////////////
// Open for any user
//////////////////////////////////////////////////////
Route::middleware(['guest'])->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    Route::post('/verify-email', VerifyEmailController::class)->middleware(['throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');
});

//////////////////////////////////////////////////////
// Logged in users
//////////////////////////////////////////////////////
Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthenticatedSessionController::class, 'me']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/users/dropdown', [UserController::class, 'getDropdown'])->name('users.dropdown');
    Route::post('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
    Route::apiResource('/users', UserController::class);
});
