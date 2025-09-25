<?php

namespace App\Http\Controllers\API\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\API\v1\Auth\ProfileUpdateRequest;

class UserController extends Controller
{
     public function profile(Request $request)
     {
        try{
            $user = $request->user();
            $cacheKey = 'user_profile_'.$user->id;
            $cached = Cache::remember($cacheKey,now()->addDay(),function() use($user){
                return new UserResource($user);
            });
            return $this->success($cached,'User profile fetched successfully');
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
            $cacheKey = 'user_profile_'.$user->id;
            Cache::put($cacheKey,new UserResource($user),now()->addDay());
            
            return $this->success(new UserResource($user),'User profile updated successfully');
        }
        catch(\Exception $e){
            Log::error('Profile Update Error: '.$e->getMessage());
            return $this->error(['Unable to update profile'],500);
        }
     }  
}
