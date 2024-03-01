<?php

use App\Models\ChatParticipant;
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

Broadcast::channel('chats.{chatId}', function ($user, int $chatId) {
    // $receiver = ChatParticipant::where('chat_id', $chatId)->where('user_id', '!=', $user->id)->first();
    $participant = ChatParticipant::where('chat_id', $chatId)->where('user_id', $user->id)->first();
    return (int) $user->id === (int) $participant->user_id;
    // return true;
});

Broadcast::channel('notifications.{userId}', function ($user, int $userId) {
    return (int) $user->id === (int) $userId;
});