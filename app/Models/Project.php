<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, RecordActivity;

    protected $guarded = [];

    protected $with = ['tasks'];

    public function path()
    {
        return '/projects/' . $this->id;
    }

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_member')->withTimestamps();
    }

    // Scopes & others
    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function scopeLastUpdatedProjects($query)
    {
        return $query->latest('updated_at')->get();
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }
}
