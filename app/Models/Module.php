<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $primaryKey = 'module_id';

    protected $fillable = ['module_name', 'description', 'user_id', 'is_completed'];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }

    // A module belongs to a supervisor (user)
    public function supervisor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A module has many tasks
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'module_id');
    }

    // Many students are assigned to a module
    public function assignedStudents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'has_user_completed', 'module_id', 'user_id')
            ->withPivot('has_completed_user');
    }
}
