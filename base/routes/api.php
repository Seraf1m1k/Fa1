<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Filter\FilterController;

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

Route::controller(TokenController::class)->group(function() {
    Route::get('/create', 'create');
});

// Protected routes
Route::middleware('auth:sanctum')->group( function () {
    Route::controller(FilterController::class)->group(function() {
        Route::get('/filtred', 'index');
        Route::get('/full', 'store');
    });
});
