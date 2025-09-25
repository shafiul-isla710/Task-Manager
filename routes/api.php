<?php 

use App\Models\User;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\UserController;

Route::post('/v1/register', [AuthController::class, 'register']);

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix'=>'auth'],function(){
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);

        Route::group(['middleware'=>'auth:sanctum'],function(){
            Route::get('profile',[UserController::class,'profile']);
            Route::put('profile/update',[UserController::class,'updateProfile']);
            Route::delete('logout',[AuthController::class,'logout']);
        });
    });

});