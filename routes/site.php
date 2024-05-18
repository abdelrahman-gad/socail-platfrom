<?php

use App\Http\Controllers\Api\Site\PostController;
use App\Http\Controllers\Api\Site\AuthController;
use App\Http\Controllers\Api\Site\ProfileController;
use Illuminate\Support\Facades\Route;



Route::
    prefix('site')
    ->group(function(){
        //Login
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);
        Route::post('verify-account',[AuthController::class,'verifyAccount']);
        Route::post('resend-otp',[AuthController::class,'resendOtp']);

        Route::middleware(['auth:sanctum','abilities:user'])->group(function(){

            Route::get('logout',[AuthController::class,'logout']);

            Route::get('show-profile',[ProfileController::class,'show']);

            // Posts
            Route::get('posts',[PostController::class,'index']);
            Route::get('posts/{id}',[PostController::class,'show']);
            Route::post('posts',[PostController::class,'store']);
        

        });



    });
