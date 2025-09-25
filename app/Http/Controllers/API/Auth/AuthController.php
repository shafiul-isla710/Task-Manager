<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\v1\Auth\LoginRequest;
use App\Http\Requests\API\v1\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{
            $user = User::create($request->validated());
            return $this->success(new UserResource($user),'User registered successfully',201);
        }
        catch (\Exception $e){
            Log::error('Registration Error: '.$e->getMessage());
            return $this->error();
        }
    }

    public function login(LoginRequest $request)
    {
        try{
            $user = User::whereEmail($request->email)->first();
            if(!Hash::check($request->password,$user->password)){
                return $this->error(['Invalid credentials'],422);
            }
            $authToken = $user->createToken('authToken')->plainTextToken;

            $data = [
                'user' => new UserResource($user),
                'token' => $authToken
            ];
            return $this->success($data,'User logged in successfully');
        }
        catch (\Exception $e){
            Log::error('Login Error: '.$e->getMessage());
            return $this->error();
        }
    }

    public function logout(Request $request)
    {
        try{
            $request->user()->currentAccessToken()->delete();
            return $this->success(null, 'User logged out successfully');
        }
        catch (\Exception $e){
            Log::error('Logout Error: ' .$e->getMessage());
            return $this->error();
        }
    }
}
