<?php

namespace App\Http\Resources\PremiumPlanSubscription;

use App\Models\PremiumPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        $plan = PremiumPlan::find($this->premium_plan_id);

        if ($plan->slug == 'waiting-list') {
            return [
                'id' => $this->id,
                'period_months' => $this->period,
                'activated_at' => Carbon::parse($this->activated_at)->format('jS F Y, H:m:s'),
                'time_ago' => Carbon::parse($this->activated_at)->diffForHumans(),
                'expires_at' => Carbon::parse($this->expires_at)->format('jS F Y, H:m:s'),
                'time_left' => Carbon::parse($this->expires_at)->diffForHumans(),
                'subscriber' => $user->username,
                'plan' => $plan->name,
                'waiting_lists' => WaitingListResource::collection($this->waitingLists),
            ];
        }

        return [
            'id' => $this->id,
            'period_months' => $this->period,
            'activated_at' => Carbon::parse($this->activated_at)->format('jS F Y, H:m:s'),
            'time_ago' => Carbon::parse($this->activated_at)->diffForHumans(),
            'expires_at' => Carbon::parse($this->expires_at)->format('jS F Y, H:m:s'),
            'time_left' => Carbon::parse($this->expires_at)->diffForHumans(),
            'subscriber' => $user->username,
            'plan' => $plan->name,
        ];
    }
}
