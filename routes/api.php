<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });
    Route::apiResource('cat', 'App\Http\Controllers\Api\CatController')->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('users', 'App\Http\Controllers\Api\UserController')->only(['index', 'show', 'update', 'destroy']);

    Route::post('/catcreator', [CatController::class, 'store']);
    Route::get('/cats/{id}', [CatController::class, 'checkUser']);
    Route::get('/search', [UserController::class, 'search']);
});


