<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('newrequest.{userId}', function ($user, $userId) {
    return $user->id === (int) $userId;
  });

Broadcast::channel('newcalendarevent', function () {
    return true;
  });

Broadcast::channel('privatecalendar.{userId}', function ($user, $userId) {
return $user->id === (int) $userId;
});

Broadcast::channel('publiccalendar', function () {
  return true;
});

Broadcast::channel('adminevent.{userId}', function ($user, $userId) {
  return $user->id === (int) $userId;
});