<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class, 'store']);
    Route::post('generateOneTimePin', [AuthenticationController::class, 'generateOneTimePin']);
    Route::post('verifyMobileNumber', [AuthenticationController::class, 'verifyMobileNumber']);
    Route::post('resetPassword', [AuthenticationController::class, 'resetPassword']);
});

Route::middleware(['api', EnsureTokenIsValid::class])->group(function () {
    Route::post('auth/logout', [AuthenticationController::class, 'logout']);
    Route::post('auth/changeUserPassword', [AuthenticationController::class, 'changePassword']);
    Route::apiResource('roles', RoleController::class)->except(['create', 'edit']);
    Route::apiResource('users', UsersController::class)->except(['create', 'edit']);
});
