<?php

use App\Http\Controllers\APIs\Backend\User\UserController;
use App\Http\Controllers\APIs\Frontend\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return response()->json(['message' => 'Something want wrong!'])->setStatusCode(404);
});
Route::get('/', function () {
    return response()->json(['message' => 'Something want wrong!'])->setStatusCode(200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/user', UserController::class);
});
