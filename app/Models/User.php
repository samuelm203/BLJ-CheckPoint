<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Die Attribute, die massenweise zugewiesen werden dürfen.
     */
    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * BEZIEHUNG: Ein User hat viele Tasks (n:m)
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_user', 'user_id', 'task_id')
            ->withPivot('is_completed', 'completion_date');
    }

    /**
     * BEZIEHUNG: Ein User hat viele Module abgeschlossen (n:m)
     */
    public function completedModules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'has_user_completed', 'user_id', 'module_id')
            ->withPivot('has_completed_user');
    }
}
