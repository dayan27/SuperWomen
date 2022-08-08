<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('comment-channel', function () {
    return true;
});

Broadcast::channel('chat', function ($user) {
    return true;
    return Auth::check();
});

Broadcast::channel('online', function ($user) {
    if (auth()->check()) {
        return $user->toArray();
    }
});


Broadcast::channel('get_mentor_message.{user_id}', function ($user, $user_id) {
   return true;
    return $user->id === $user_id;
});

Broadcast::channel('get_user_message.{mentor_id}', function ($mentor, $mentor_id) {
    return $mentor_id === $mentor->id;
});
