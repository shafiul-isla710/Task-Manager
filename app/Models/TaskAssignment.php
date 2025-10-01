<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $table = 'task_assignments';

    protected $fillable = [
        'task_id',
        'assignee_type',
        'assignee_id',
        'assigned_by',
        'assigned_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function assigneeIdUser()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function assigneeIdGroup()
    {
        return $this->belongsTo(Group::class, 'assignee_id');
    }
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    
}
