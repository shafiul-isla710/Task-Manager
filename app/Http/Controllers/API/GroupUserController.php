<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GroupUserController extends Controller
{
    public function list(Request $request, Group $group)
    {
        try{
            $per_page = min(100,(int) $request->get('per_page', 15));
            $groupUsers = $group->users()->paginate($per_page);
            return $this->success($groupUsers, 'Users from group fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Error show user from group: '.$e->getMessage());
            return $this->error(['Failed to remove user from group'], 500);
        }
    }
    public function store(Request $request, $id)
    {
        try{
            $validated = $request->validate([
                'user_id'   => 'exists:users,id|required_without:user_ids',
                'user_ids'  => 'array|min:1|required_without:user_id',
                'user_ids.*'=> 'exists:users,id',
            ]);

            // dd($validated);

            $group = Group::findOrFail($id);
            if(isset($validated['user_id'])){
                if(!$group->users->contains($validated['user_id'])){
                    $group->users()->attach($validated['user_id']);
                }
                else{
                    return $this->error(['User already in group'], 400);
                }
            }

            if(isset($validated['user_ids'])){
                $difference = array_diff($validated['user_ids'], $group->users->pluck('id')->toArray());
                if(!empty($validated['user_ids']) && empty($difference)){
                    return $this->error(['All users are already in group'], 400);
                }
                $group->users()->attach($difference);
            }

            return $this->success([], 'Users added to group successfully');
        }
        catch(\Exception $e){

            Log::error('Error adding users to group: '.$e->getMessage());
            return $this->error(['Failed to add users to group'], 500);
        }
    }

    

    public function removeUser(Request $request, Group $group, $user_id)
    {
        try{
            $group->users()->detach($user_id);
            return $this->success([], 'User removed from group successfully');
        }
        catch(\Exception $e){
            Log::error('Error removing user from group: '.$e->getMessage());
            return $this->error(['Failed to remove user from group'], 500);
        }
    }
    
}      
