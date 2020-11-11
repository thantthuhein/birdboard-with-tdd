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

        $ownername = $this->user->name;
        return "{$ownername}" . " {$description}";           
    }
}
