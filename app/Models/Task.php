<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, RecordActivity;

    protected $guarded = [];

    /**
     * The attributes default value.
     *
     * @var array
     */
    protected $attributes = ['completed' => false];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['completed' => 'boolean'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['project'];

    /**
     * To the project path
     * 
     * @return string
     */
    public function path()
    {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    // Scopes and others
    public function is_completed()
    {        
        return $this->completed;        
    }

    public function is_pending()
    {
        return ! $this->completed;
    }

    public function complete()
    {
        
        $this->update(['completed' => true]);        
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
    }
}
