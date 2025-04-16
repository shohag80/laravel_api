<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status_code' => 200,
        'message' => 'Welcome to Laravel 12!'
    ])->setStatusCode(200);
});
