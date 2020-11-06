<?php

namespace App\Traits;

use App\Models\Activity;

trait TriggersActivity {
     /** 
      * Boot the trait
      */
     protected static function bootTriggersActivity()
     {
          foreach (static::getModelEvents() as $event) {
               static::$event(function($model) use ($event) {
                    $model->recordActivity(
                         $model->formatActivityDescription($event)
                    );
               });
          }     
     }

     
     /**
      * Record Activity for the model
      * 
      * @param string $description
      *
      * @return void
      */
     protected function recordActivity($description)
     {
          $this->activities()->create(compact('description'));
     }
     
     /**
      * The Activity feed for model
      * 
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     protected function activities()
     {
          return $this->hasMany(Activity::class);
     }


     /**
      * Get the models events to trigger, can be overrided in model
      * 
      * @return array
      */
     protected static function getModelEvents()
     {
          if (isset(static::$modelEvents)) {
               return static::$modelEvents;
          }

          return ['created', 'updated', 'deleted'];
     }

     /**
      * Format the activity description
      * 
      * @param string $event
      */
     protected function formatActivityDescription(string $event)
     {
          return strtolower(class_basename($this)) . "_{$event}";
     }
}