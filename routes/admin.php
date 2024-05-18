<?php



use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Dashboard\PostController;
use App\Http\Controllers\Api\Dashboard\UserController;
use App\Http\Controllers\Api\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;

Route::
    prefix('admin')
    ->namespace('Api\Dashboard')
    ->group(function(){

Route::middleware(['auth:sanctum', 'admin'])
            ->group(function () {
                Route::get('/user', [AuthController::class, 'getUser']);
                Route::post('/logout', [AuthController::class, 'logout']);

                Route::apiResource('posts', PostController::class);
                Route::apiResource('users', UserController::class);
                // Dashboard Routes
                
                Route::get('/dashboard/users-count', [DashboardController::class, 'activeUsers']);

                Route::get('/dashboard/posts-count', [DashboardController::class, 'activePosts']);
                
            });

            Route::post('/login', [AuthController::class, 'login']);

    });