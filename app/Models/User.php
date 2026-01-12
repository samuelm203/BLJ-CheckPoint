<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'password',
        'role',
        'supervisor_id',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * BEZIEHUNG: Ein Student hat einen Supervisor (n:1)
     */
    public function supervisor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * BEZIEHUNG: Ein Supervisor hat viele Studenten (1:n)
     */
    public function students(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    /**
     * BEZIEHUNG: Ein Supervisor hat viele erstellte Module (1:n)
     */
    public function createdModules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Module::class, 'user_id');
    }

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
     * BEZIEHUNG: Ein User hat viele Module zugewiesen (n:m)
     */
    public function assignedModules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'has_user_completed', 'user_id', 'module_id')
            ->withPivot('has_completed_user');
    }
}
