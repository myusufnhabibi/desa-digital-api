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

