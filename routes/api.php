<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("user", \App\Http\Controllers\UserController::class);
Route::get("user/all/paginated", [\App\Http\Controllers\UserController::class, 'getAllPaginated']);

Route::apiResource("head-of-family", \App\Http\Controllers\HeadOfFamilyController::class);
Route::get("head-of-family/all/paginated", [\App\Http\Controllers\HeadOfFamilyController::class, 'getAllPaginated']);
