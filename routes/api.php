<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("user", \App\Http\Controllers\UserController::class);
Route::get("user/all/paginated", [\App\Http\Controllers\UserController::class, 'getAllPaginated']);

Route::apiResource("head-of-family", \App\Http\Controllers\HeadOfFamilyController::class);
Route::get("head-of-family/all/paginated", [\App\Http\Controllers\HeadOfFamilyController::class, 'getAllPaginated']);

Route::apiResource("family-member", \App\Http\Controllers\FamilyMemberController::class);
Route::get("family-member/all/paginated", [\App\Http\Controllers\FamilyMemberController::class, 'getAllPaginated']);

Route::apiResource("social-assistance", \App\Http\Controllers\SocialAssistanceController::class);
Route::get("social-assistance/all/paginated", [\App\Http\Controllers\SocialAssistanceController::class, 'getAllPaginated']);

Route::apiResource("social-assistance-recepient", \App\Http\Controllers\SocialAssistanceRecepientController::class);
Route::get("social-assistance-recepient/all/paginated", [\App\Http\Controllers\SocialAssistanceRecepientController::class, 'getAllPaginated']);

Route::apiResource("event", \App\Http\Controllers\EventController::class);
Route::get("event/all/paginated", [\App\Http\Controllers\EventController::class, 'getAllPaginated']);

Route::apiResource("event-participant", \App\Http\Controllers\EventParticipantController::class);
Route::get("event-participant/all/paginated", [\App\Http\Controllers\EventParticipantController::class, 'getAllPaginated']);

Route::apiResource("development", \App\Http\Controllers\DevelopmentController::class);
Route::get("development/all/paginated", [\App\Http\Controllers\DevelopmentController::class, 'getAllPaginated']);

Route::apiResource("development-applicant", \App\Http\Controllers\DevelopmentApplicantController::class);
Route::get("development-applicant/all/paginated", [\App\Http\Controllers\DevelopmentApplicantController::class, 'getAllPaginated']);

// Route::apiResource("profile", \App\Http\Controllers\ProfileController::class);
Route::get("profile", [\App\Http\Controllers\ProfileController::class, 'index']);
Route::post("profile", [\App\Http\Controllers\ProfileController::class, 'store']);
Route::put("profile", [\App\Http\Controllers\ProfileController::class, 'update']);
