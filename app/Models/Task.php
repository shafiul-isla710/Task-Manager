<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use SoftDeletes;

    public const STATUSES = [
        'created',
        'assigned',
        'progress',
        'hold',
        'completed',
        'cancelled'

    ];
    protected $fillable = [
        'created_by',
        'title',
        'description',
        'status',
    ];
    protected $date = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
