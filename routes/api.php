<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DisabilityController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\HealthConditionController;
use App\Http\Controllers\NextOfKinController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkDutyController;
use App\Http\Controllers\WorkExperienceController;
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
    Route::post('generateEmailVerificationCode', [AuthenticationController::class, 'generateEmailVerificationCode']);
    Route::post('verifyEmail', [AuthenticationController::class, 'verifyEmail']);
    Route::post('resetPassword', [AuthenticationController::class, 'resetPassword']);
});

Route::middleware(['api', EnsureTokenIsValid::class])->group(function () {
    Route::post('auth/logout', [AuthenticationController::class, 'logout']);
    Route::post('auth/changeUserPassword', [AuthenticationController::class, 'changePassword']);
    Route::apiResource('roles', RoleController::class)->except(['create', 'edit']);
    Route::apiResource('users', UsersController::class)->except(['create', 'edit']);
    Route::apiResource('references', ReferenceController::class)->except(['create', 'edit']);
    Route::apiResource('profiles', UserProfileController::class)->except(['create', 'edit']);
    Route::apiResource('nextOfKin', NextOfKinController::class)->except(['create', 'edit']);
    Route::apiResource('healthConditions', HealthConditionController::class)->except(['create', 'edit']);
    Route::apiResource('documentTypes', DocumentTypeController::class)->except(['create', 'edit']);
    Route::apiResource('disabilities', DisabilityController::class)->except(['create', 'edit']);
    Route::apiResource('workExperience', WorkExperienceController::class)->except(['create', 'edit']);
    Route::apiResource('workExperienceDuties', WorkDutyController::class)->except(['create', 'edit']);
});
