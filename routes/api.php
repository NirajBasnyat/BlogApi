<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('users-list', [UserApiController::class, 'usersList']);

    Route::get('my-blogs', [BlogApiController::class, 'myBlogs']);
    Route::apiResource('blogs', BlogApiController::class);

    Route::apiResource('blogs.comments', CommentApiController::class)->except(['index', 'show']);
});