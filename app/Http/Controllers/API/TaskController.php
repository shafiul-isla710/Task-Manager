<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try{

            // $perPage = min(100,(int) request()->query('per_page', 20));
            // $query = Task::query();

            // $tasks = $query->latest('created_at')->paginate($perPage);
            $tasks = Task::orderBy('created_at','desc')->paginate(3);

            return $this->success($tasks,'Tasks fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Task Fetch Error: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
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
    public function store(TaskStoreRequest $request):JsonResponse
    {
        try{
            $status = Task::STATUSES;// get the statuses from the model

            $data = $request->validated();
            $data['created_by'] = $request->user()->id;
            if($request->status){
                $data['status'] = $request->status;
            }
            $data['status'] = $status[0];
            $task = Task::create($data);

            return $this->success($task,'Task created successfully',201);
        }
        catch(\Exception $e){
            Log::error('Task Creation Error: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task):JsonResponse
    {
        try{
            return $this->success($task,'Task fetched successfully');
        }
        catch(\Exception $e){
            Log::error('Task Fetch Error: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
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
    public function update(TaskUpdateRequest $request, Task $task ,):JsonResponse
    {
        try{
            $data = $request->validated();
            $task->update($data);
            return $this->success($task,'Task updated successfully');
        }
        catch(\Exception $e){
            Log::error('Task Update Error: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task):JsonResponse
    {
        try{
            $task->delete();
            return $this->success(null,'Task deleted successfully');
        }
        catch(\Exception $e){
            Log::error('Task Deletion Error: '.$e->getMessage());
            return $this->error([$e->getMessage()],500);
        }
    }
    
}
