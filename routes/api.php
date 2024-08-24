<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutobotController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['throttle:5,1'])->group(function () {
    Route::apiResource('autobots', AutobotController::class);
    Route::get('autobots/{id}/posts', [AutobotController::class, 'posts']);
    Route::get('posts/{post}/comments', [PostController::class, 'comments']);
});
