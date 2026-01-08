<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Module extends Model
{
    protected $primaryKey = 'module_id'; // Wichtig, da wir nicht 'id' nutzen
    protected $fillable = ['module_name', 'description'];

    // Ein Modul hat viele Tasks
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'module_id', 'module_id');
    }

    // Ein Modul wird von vielen Usern abgeschlossen (n:m)
    public function completedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'has_user_completed', 'module_id', 'user_id')
            ->withPivot('has_completed_user');
    }
}
