<?php 

use App\Models\User;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\UserController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\API\TaskController;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix'=>'auth'],function(){
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);

        Route::post('send-otp',[ForgotPasswordController::class,'sendOtp']);
        Route::post('verify-otp',[ForgotPasswordController::class,'verifyOtp']);
        Route::post('reset-password',[ForgotPasswordController::class,'resetPassword']);

        Route::group(['middleware'=>'auth:sanctum'],function(){
            Route::get('profile',[UserController::class,'profile']);
            Route::put('profile/update',[UserController::class,'updateProfile']);
            Route::delete('logout',[AuthController::class,'logout']);
        });
    });

    Route::group(['middleware'=>'auth:sanctum'],function(){
        Route::resource('tasks',TaskController::class);
    });

});