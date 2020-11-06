<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait RecordActivity {

     /**
      * The model's old attributes.
      *
      * @var array
      */
     public $oldAttributes = [];

     /**
      * Boot the trait.
      */
     public static function bootRecordActivity()
     {
          /**
           * Handle the model's "updating" event.
           *
           * @return void
           */
          static::updating(function($model) {
               $model->oldAttributes = $model->getOriginal();
          });
     }
     
     /**
      * Record Activity for the model
      * 
      * @param string $description
      * 
      * @return void
      */
     public function recordActivity($description)
     {
          $this->activities()->create([
               'user_id'      => ($this->project ?? $this)->owner->id,
               'description'  => $description,
               'stateChanges' => $this->activityChanges(),
               'project_id'   => class_basename($this) === 'Project' ? $this->id : $this->project_id,
          ]);
     }

     /**
      * Fetch the changes to the model
      * 
      * @return array|null
      */
     public function activityChanges()
     {
          if ($this->wasChanged()) {
               return [
                    'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), ['created_at', 'updated_at']),
                    'after' => Arr::except($this->getChanges(), ['created_at', 'updated_at'])
               ];
          }
     }
}