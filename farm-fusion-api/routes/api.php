<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
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

// Authentication Routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // User management routes - accessible to all authenticated users
    Route::get('/users', [UserController::class, 'index']);
    
    // Owner-only routes
    Route::middleware('role:Owner')->group(function () {
        Route::post('/users', [UserController::class, 'store']);
    });
}); 