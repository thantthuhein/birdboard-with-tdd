<?php

Route::post('/projects/{project}/invitations', 'ProjectInvitationController@store')->name('projects.sendInvitation');