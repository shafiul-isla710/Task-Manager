<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Group\GroupStoreRequest;
use App\Http\Requests\API\v1\Group\GroupUpdateRequest;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $data = Group::all();
            return $this->success($data,'Groups fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Group fetch error: '.$e->getMessage());
            return response()->json(['error'=>'Server Error'],500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupStoreRequest $request)
    {
        try{
            $data = $request->validated();
            $group = Group::create($data);
            return $this->success($group,'Group created successfully',201);
        }
        catch(\Exception $e){
            Log::error('Group creation error: '.$e->getMessage());
            return $this->error();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        try{
            return $this->success($group,'Group fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Group fetch error: '.$e->getMessage());
            return response()->json(['error'=>'Server Error'],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        try{
            $data = $request->validated();
            $group->update($data);
            return $this->success($group,'Group updated successfully');
        }
        catch(\Exception $e){
            Log::error('Group update error: '.$e->getMessage());
            return response()->json(['error'=>'Server Error'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try{
            $group->delete();
            return $this->success([],'Group Deleted successfully');
        }
        catch(\Exception $e){
            Log::error('Group update error: '.$e->getMessage());
            return response()->json(['error'=>'Server Error'],500);
        }
    }
}
