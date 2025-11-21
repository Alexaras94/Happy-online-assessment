<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
    Route::post('register', [AuthController::class,'register']);



});


Route::resource('posts', PostController::class)->except(['create', 'edit']);

Route::resource('comments', CommentController::class)->only(['store', 'update', 'destroy']);

Route::post('comments', [CommentController::class, 'store']);

// User specific
Route::get('users/{id}/posts', [PostController::class, 'getUserPosts']);
Route::get('users/{id}/comments', [CommentController::class, 'getUserComments']);

// Categories
Route::get('categories', CategoryController::class);
