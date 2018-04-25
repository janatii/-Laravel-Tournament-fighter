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

use App\Models\Match;
use App\Models\User;

Broadcast::channel('user.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('team.{id}', function (User $user, $id) {
    if ($user->activeTeam->id == $id) {
        return ['id' => $user->id, 'username' => $user->username];
    }
});

Broadcast::channel('match.{match}', function (User $user, Match $match) {
    return $user->canSeeChat($match);
});
