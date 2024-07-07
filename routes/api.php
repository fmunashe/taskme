<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ConnectController;
use App\Http\Controllers\DisabilityController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentsVerificationController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\HealthConditionController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\NextOfKinController;
use App\Http\Controllers\RecordStatusController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceListingController;
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
    Route::post('socialLogin', [AuthenticationController::class, 'socialLogin']);
    Route::post('register', [AuthenticationController::class, 'store']);
    Route::post('socialSignup', [AuthenticationController::class, 'socialSignup']);
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
    Route::apiResource('Documents', DocumentController::class)->except(['create', 'edit']);
    Route::group(['prefix' => 'documentVerification'], function () {
        Route::post('verifyCV', [DocumentsVerificationController::class, 'verifyCV']);
        Route::post('verifyNationalId', [DocumentsVerificationController::class, 'verifyNationalId']);
        Route::post('verifyPassport', [DocumentsVerificationController::class, 'verifyPassport']);
        Route::post('verifyProofOfResidence', [DocumentsVerificationController::class, 'verifyProofOfResidence']);
        Route::post('verifyPoliceClearance', [DocumentsVerificationController::class, 'verifyPoliceClearance']);
    });
    Route::apiResource('serviceCategories', ServiceCategoryController::class)->except(['create', 'edit']);
    Route::apiResource('serviceListings', ServiceListingController::class)->except(['create', 'edit']);
    Route::apiResource('recordStatuses', RecordStatusController::class)->except(['create', 'edit']);
    Route::apiResource('jobCategories', JobCategoryController::class)->except(['create', 'edit']);
    Route::apiResource('jobListings', JobListingController::class)->except(['create', 'edit']);
    Route::apiResource('connects', ConnectController::class)->except(['create', 'edit']);
    Route::apiResource('eventTypes', EventTypeController::class)->except(['create', 'edit']);
});
