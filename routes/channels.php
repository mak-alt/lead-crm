<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Lead;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
// 

Broadcast::channel('lead-discussion.{leadId}', function ($user,$leadId) {
  return Auth::check();
});

Broadcast::channel('task-discussion.{taskId}', function ($user,$taskId) {
  return Auth::check();
});
