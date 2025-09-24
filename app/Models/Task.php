<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'assigned_to',
        'title',
        'description',
        'status',
    ];

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function assignTo():BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function task():HasMany
    {
        return $this->hasMany(Task::class);
    }
}
