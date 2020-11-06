<?php

// Project Routes
Route::resource('projects', 'ProjectController')->middleware(['auth']);

// Project Tasks
Route::middleware(['auth'])->prefix('projects')->group(function () {
    Route::post('/{project}/tasks', 'ProjectTaskController@store')->name('projects.tasks.store');
    Route::patch('/{project}/tasks/{task}', 'ProjectTaskController@update')->name('projects.tasks.update');
    Route::delete('/{project}/tasks/{task}', 'ProjectTaskController@destroy')->name('projects.tasks.destroy');
});
