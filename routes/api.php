<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource("user", \App\Http\Controllers\UserController::class);
Route::get("user/all/paginated", [\App\Http\Controllers\UserController::class, 'getAllPaginated']);
