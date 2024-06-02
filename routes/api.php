<?php

use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ItemController;
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
    'middleware' => ['auth:sanctum', 'autisms'],
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });
    
    Route::apiResource('cat', 'App\Http\Controllers\Api\CatController')->only(['index', 'show', 'update', 'destroy']);
    Route::apiResource('users', 'App\Http\Controllers\Api\UserController')->only(['index', 'show', 'destroy']);
    Route::apiResource('items', 'App\Http\Controllers\Api\ItemController');

    // Route::post('/createitem', [ItemController::class, 'store']);
    Route::post('/user/{user}/update', [UserController::class, 'update']);
    Route::get('/item/{id}', [ItemController::class, 'show']);
    Route::post('/item/{id}/update', [ItemController::class, 'update']);

    Route::get('/usercount', [UserController::class, 'userCount']);

    Route::get('/posts', [UploadController::class, 'index']);
    Route::get('/friendships', [UserController::class,'indexFriendships']);
    Route::get('/latestuser', [UserController::class,'mostRecentSignup']);
    Route::get('/itemcount', [ItemController::class,'itemCount']);

    Route::get('/search/items', [ItemController::class, 'search']);

    Route::post('/catcreator', [CatController::class, 'store']);
    Route::get('/cats/{id}', [CatController::class, 'checkUser']);
    Route::get('/search', [UserController::class, 'search']);
    Route::post('/addfriend', [UserController::class, 'friend']);
    Route::get('user/{id}/friends', [UserController::class, 'showFriends']);
    Route::get('user/{id}/pendingfriends', [UserController::class, 'showPendingFriends']);
    Route::get('user/{id}/incomingfriends', [UserController::class, 'showIncomingFriends']);
    Route::post('friendshipaccept/{id}', [UserController::class, 'acceptFriend']);
    Route::post('friendshipdecline/{id}', [UserController::class, 'declineFriend']);
    Route::post('user/{id}/post', [UploadController::class, 'upload']);
    Route::get('user/{id}/posts', [UploadController::class, 'showPosts']);
    Route::post('posts/{id}/delete', [UploadController::class,'deletePost']);
    Route::post('posts/{post_id}/user/{user_id}/like', [UploadController::class,'likePost']);
    Route::get('/user/{id}/updatestatus', [UserController::class, 'updateUserStatus']);

});


