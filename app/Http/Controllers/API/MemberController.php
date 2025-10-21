<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;


class MemberController extends Controller
{
    public function getMembers(Request $request)
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
    public function member(Request $request)
    {
        try{
            $member = User::user()->where('id',$request->id)->first();
            $designations = User::designation();
            $data = [
                'member' => new UserResource($member),
                'designations' => $designations
            ];
            return $this->success($data,'Member fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Member Error: '.$e->getMessage());
            return $this->error();
        }
    }

    public function setDesignation(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'designation' => 'required|in:' . implode(',', User::designation())
            ]);

            if($validator->fails()){
                return $this->error($validator->errors()->all(),422);
            };

            $member = User::user()->where('id',$request->id)->first();
            $member->designation = $request->designation;
            $member->save();

            return $this->success('','Designation changed successfully');
        }
        catch(\Exception $e){
            Log::error('Member Error: '.$e->getMessage());
            return $this->error();
        }
    }

}
