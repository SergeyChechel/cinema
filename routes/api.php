<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;

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

Route::apiResource('genres', GenreController::class);
Route::get('genres/{genre}', [GenreController::class, 'show']);
Route::apiResource('movies', MovieController::class);
Route::patch('movies/{movie}/publish', [MovieController::class, 'publish'])->name('movies.publish');


