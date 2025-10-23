<?php 

use App\Models\User;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\UserController;
use App\Http\Controllers\API\GroupUserController;
use App\Http\Controllers\API\TaskAssignmentController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;

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
    
    //resource routes for tasks and groups
    Route::group(['middleware'=>'auth:sanctum'],function(){
        Route::apiResource('tasks',TaskController::class);
        Route::apiResource('groups',GroupController::class);

        Route::post('groups/user/{id}',[GroupUserController::class, 'store']);
        Route::get('groups/{group}/user',[GroupUserController::class, 'list']);
        Route::get('group/{id}/user',[GroupUserController::class, 'show']);
        Route::delete('groups/{group}/user/{user_id}',[GroupUserController::class, 'removeUser']);
        
        //task assignment
        Route::post('tasks/{task}/assign',[TaskAssignmentController::class,'store']);
        Route::get('tasksAssignments',[TaskAssignmentController::class,'index']);

        //member controller
        Route::get('members',[MemberController::class,'getMembers']);
        //get single member
        Route::get('member/{id}',[MemberController::class,'member']);
        Route::put('member/{id}',[MemberController::class,'setDesignation']);
    });


});