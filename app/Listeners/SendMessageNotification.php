<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Http\Controllers\Api\NotificationsController;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        // dd($event->message->body);
        app(NotificationsController::class)->sendMessageNotification($event->message);
    }
}
