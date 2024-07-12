<?php

namespace App\Jobs;

use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\Api\PremiumSubscriptionsController;
use App\Models\PremiumPlan;
use App\Models\PremiumPlanWaitingList;
use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyWaitingListSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Property $property)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $zone = $this->property->subZone->zone;
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        $waitingLists = PremiumPlanWaitingList::where('zone_id', $zone->id)->get();

        // $subscribers = [];
        foreach ($waitingLists as $list) {
            $user = $list->premiumPlanSubscription->user;
            if (app(PremiumSubscriptionsController::class)->doesUserHaveValidWaitingListSubscription($user, $plan, $list->premiumPlanSubscription)) {
                // array_push($subscribers, $user);
                app(NotificationsController::class)->sendWaitingListNotification($this->property, $user, $zone, $this->property->subZone);
            }
        }
    }
}
