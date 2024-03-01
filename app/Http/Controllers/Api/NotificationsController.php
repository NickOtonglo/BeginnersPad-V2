<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
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

        $data = new Notification();
        $data->title = "New message from @".$sender->username;
        $data->body = "You have received a new message. Click here to open your chats.";
        $data->model = "Chat";
        $data->model_id = $message->chat_id;
        $data->user_id = $receiver->id;

        $data->save();
        
        // dd(Notification::where('user_id', auth()->user()->id)->latest()->first()); 
        NotificationSent::dispatch($data);
    }

    public function index() {
        $notifications = auth()->user()->notifications;
        return NotificationResource::collection($notifications);
    }

    public function destroy(string $model, int $modelId) {
        $notifications = auth()->user()->notifications()
                            ->where('model', $model)
                            ->where('model_id', $modelId)
                            ->where('read', boolval(0))
                            ->delete();

        // $notifications->delete();
        
        return response()->noContent();
    }

    public function getBadges() {
        // $notifications = auth()->user()->notifications;
        $help = auth()->user()->notifications()->where('Model', 'HelpTicket')->where('read', boolval(0))->count();
        $account = auth()->user()->notifications()->where('Model', 'User')->where('read', boolval(0))->count();
        $chat = auth()->user()->notifications()->where('Model', 'Chat')->where('read', boolval(0))->count();

        return response()->json([
            'help' => $help, 
            'account' => $account, 
            'chat' => $chat, 
        ]);
    }
}
