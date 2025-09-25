<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\API\v1\Auth\ProfileUpdateRequest;

class UserController extends Controller
{
     public function profile(Request $request)
     {
        try{
            $user = $request->user();
            return $this->success(new UserResource($user),'User profile fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Profile Error: '.$e->getMessage());
            return $this->error(['Unable to fetch profile'],500);
        }
     }

     public function updateProfile(ProfileUpdateRequest $request)
     {
        try{

            
            $user = $request->user();
            $user->update($request->validated());
            
            return $this->success(new UserResource($user),'User profile updated successfully');
        }
        catch(\Exception $e){
            Log::error('Profile Update Error: '.$e->getMessage());
            return $this->error(['Unable to update profile'],500);
        }
     }  
}
