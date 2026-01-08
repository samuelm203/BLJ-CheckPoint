<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $primaryKey = 'task_id';
    protected $fillable = ['title', 'module_id'];

    // One task belongs to one module
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id', 'module_id');
    }

    // Many users can complete a task
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
            ->withPivot('is_completed', 'completion_date');
    }
}
