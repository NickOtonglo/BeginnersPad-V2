<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\HelpTicket;
use App\Models\Notification;
use App\Models\Property;
use App\Models\PropertyLog;
use App\Models\PropertyReviewRemovalLog;
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

    public function sendReviewRemovedNotification(PropertyReviewRemovalLog $log) {
        $property = Property::find($log->property_id);
        $title = "";
        $body = "Hello there! Your review was removed due to the following reason: ".$log->removal_reason.", which is a violation of our 'Terms of Service'.";
        if ($property) {
            $title = "Your review of listing '".$property->name."' was removed.";
        } else {
            $title = "Your review of a listing was removed.";
        }

        if ($log->reason_details) {
            $body = $body." The following comment was given in relation to the removal: \r\n".$log->reason_details;
        }
        $body = $body."\r\nYour review read as follows:\r\n - ".$log->review." -\r\n If you have any questions or concerns, please contact support.";

        $data = new Notification();
        $data->title = $title;
        $data->body = $body;
        // $data->model = "";
        // $data->model_id = "";
        $data->user_id = $log->author_id;

        $data->save();

        NotificationSent::dispatch($data);
    }

    public function sendPropertyNotification(Property $property, PropertyLog $log) {
        $title = "Your listing '".$property->name."' was ".$property->status.".";
        $body = "Hello there! Your property '".$property->name."' was ".$property->status.".\r\n" ;
        if ($property->status !== 'published') {
            $body = $body." The following reason was given: ".$log->comment;
        }
        $body = $body."\r\n If you have any questions or concerns, please contact support.";
        
        $data = new Notification();
        $data->title = $title;
        $data->body = $body;
        $data->model = "Property";
        $data->model_id = $property->slug;
        $data->user_id = $property->user_id;

        $data->save();
        
        NotificationSent::dispatch($data);
    }

    public function sendHelpNotification(HelpTicket $ticket) {
        $title = "";
        $body = "";
        if ($ticket->status == "pending") {
            $title = "Ticket #".$ticket->id.": your ticket has been assigned to a member of the support team.";
        } else if ($ticket->status == "reopened") {
            $title = "Ticket #".$ticket->id.": your ticket has been reopened.";
        } else {
            $title = "Ticket #".$ticket->id.": status set to".$ticket->status.".";
        }
        
        if ($ticket->status == "pending" || $ticket->status == "reopened") {
            $body = "Hello there! Your ticket #" . $ticket->id . " has been assigned to a member of the support team and is currently being worked on. 
                    You shall be contacted by our team if any additional information is required from you concerning the ticket. 
                    Otherwise, you shall be notified if any updates occur.\r\n";
        } else {
            $body = "Hello there! Your ticket #" . $ticket->id . " has been ".$ticket->status.". 
                    You shall be contacted by our team if any additional information is required from you concerning the ticket. 
                    Otherwise, you shall be notified if any updates occur.\r\n";
        }
       
        $body = $body."\r\n If you have any questions or concerns, please contact support.";

        $user = User::where('email', $ticket->email)->first();
        if ($user) {
            $data = new Notification();
            $data->title = $title;
            $data->body = $body;
            $data->model = "HelpTicket";
            $data->model_id = $ticket->id;
            $data->user_id = $user->id;

            $data->save();

            NotificationSent::dispatch($data);
        }
    }

    public function index() {
        $notifications = auth()->user()->notifications()->latest()->get();
        return NotificationResource::collection($notifications);
    }

    public function getUnreadNotifications() {
        $notifications = auth()->user()->notifications()->where('read', boolval(0))->latest()->get();
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
        $noModel = auth()->user()->notifications()->where('Model', null)->where('read', boolval(0))->count();
        $other = auth()->user()->notifications()
                ->where('Model', '!=', 'HelpTicket')->where('Model', '!=', 'User')->where('Model', '!=', 'Chat')
                ->where('read', boolval(0))->count();
        $chat = auth()->user()->notifications()->where('Model', 'Chat')->where('read', boolval(0))->count();

        return response()->json([
            'help' => $help, 
            'account' => $account+$noModel+$other, 
            'chat' => $chat, 
        ]);
    }

    public function setToRead(Notification $notification) {
        if (!$notification->read) {
            $notification->read = true;
            $notification->save();
    
            $response = [
                'notification' => $notification,
                'message' => "Notification read status changed to true.",
            ];
            return response($response, 201);
        }
    }
}
