<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Cast the attributes value.
     *
     * @var array
     */
    protected $casts = [
        'stateChanges' => 'array'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes and others
    /**
     * Format the description to proper string.
     * 
     * @return string
     */
    public function activityDetails()
    {
        $descriptions = collect(config('format.activity.description'));
        // Filter the description match with format config
        $description = $descriptions->filter(fn($description, $key) => $key == $this->description)->first();

        return $this->formatDescription($description);                
    }
    
    public function formatDescription($description)
    {
        $ownername = auth()->user()->name;

        if (is_null($this->stateChanges) || $this->description !== 'project_updated') {
            $task = optional($this->subject)->body
                        ? "''" . optional($this->subject)->body . "''" 
                        : '';
                        
            return "{$ownername}" . " {$description} " . "{$task}";
        }
        
        // If the user updated only one field, show them specific
        if (count($this->stateChanges['after']) === 1) {
            return "{$ownername}" . " Updated the " . ucfirst(key($this->stateChanges['after'])) . " of the Project";
        }

        return "{$ownername}" . " {$description}";
    }
}
