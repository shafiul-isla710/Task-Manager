<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskAssignmentRequest;

class TaskAssignmentController extends Controller
{   
    public function index(Request $request)
    {
        try {
            $perPage = min(100, (int) $request->query('per_page', 10));

            $taskAssignments = TaskAssignment::with('assigneeIdUser','assigneeIdGroup')->latest('created_at')->paginate($perPage);

            return $this->success($taskAssignments, 'Task assignments fetched successfully');

        } catch (\Exception $e) {
            Log::error('Task Assignment Fetch Failed: ' . $e->getMessage());
            return $this->error(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function store(TaskAssignmentRequest $request, Task $task)
    {
        try {
            $data = $request->validated();
            $user = auth()->user();

            // Add required fields
            $data['task_id']     = $task->id;
            $data['assigned_by'] = $user->id;
            $data['assigned_at'] = now();

            $alreadyAssigned = TaskAssignment::where('task_id', $task->id)
                                ->where('assignee_id', $data['assignee_id'])
                                ->exists();

            if ($alreadyAssigned) {
                return $this->error(['error' => 'This user is already assigned to this task'], 422);
            }

            // ✅ Create assignment
            TaskAssignment::create($data);

            return $this->success(null, 'Task assigned successfully');
        } catch (\Exception $e) {
            Log::error('Task Assignment Failed: ' . $e->getMessage());
            return $this->error(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    //Todo Task Assignment Delete

}
