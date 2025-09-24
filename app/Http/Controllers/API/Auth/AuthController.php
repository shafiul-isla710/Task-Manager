<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Auth\RegisterRequest;
use App\Http\Resources\UserResource;

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
}
