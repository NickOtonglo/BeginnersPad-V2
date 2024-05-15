<?php

namespace App\Listeners;

use App\Events\NotificationSent;
use App\Http\Controllers\Api\NotificationsController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationSent $event): void
    {
        // dd($event->notification);
        // app(NotificationsController::class)->sendReviewRemovedNotification($event->notification);
        // the above method has already been called in 'Middleware/CreateUserActivityLog.php'
    }
}
