<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function sendMessageNotification(ChatMessage $message) {
        $sender = auth()->user();
        // $receiver = Chat::find($this->message->chat_id)->chatParticipants()->where('user_id', '!=', auth()->user()->id)->first();
        $receiverId = ChatParticipant::where('chat_id', $message->chat_id)->where('user_id', '!=', auth()->user()->id)->first()->user_id;
        $receiver = User::find($receiverId);

        $notification = new Notification();
        $notification->title = "New message from @".$sender->username;
        $notification->body = "You have received a new message. Click here to open your chats.";
        $notification->model = "Chat";
        $notification->model_id = $message->chat_id;
        $notification->user_id = $receiver->id;
        $notification->save();
    }
}
