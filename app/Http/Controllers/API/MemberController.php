<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MemberController extends Controller
{
    public function getMember(Request $request)
    {
        try{
            $member = User::user()->get();
            return $this->success(UserResource::collection($member),'Member fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Member Error: '.$e->getMessage());
            return $this->error();
        }
    }
}
