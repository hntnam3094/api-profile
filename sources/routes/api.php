<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/blog', [App\Http\Controllers\Api\BlogController::class, 'index']);
// Route::get('/blog/{slug}', [App\Http\Controllers\Api\BlogController::class, 'getBlogByCategorySlug'])->where('slug', '[A-Za-z0-9-]+');;
Route::get('/blog/{slug}', [App\Http\Controllers\Api\BlogController::class, 'show']);

Route::get('/category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
