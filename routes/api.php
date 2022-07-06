<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/', [PostController::class, 'index']);
    Route::get('/posts/{post:slug}', [PostController::class, 'show']);

    Route::post('/admin/posts', [PostController::class, 'store'])->middleware('admin');
    Route::patch('/admin/posts/{post:slug}', [PostController::class, 'update'])->middleware('admin');
    Route::delete('/admin/posts/{post:slug}', [PostController::class, 'destroy'])->middleware('admin');

    Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store']);
});

Route::post('/signup', [AuthController::class, 'signup'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
