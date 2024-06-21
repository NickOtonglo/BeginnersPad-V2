<?php

namespace App\Http\Resources\PremiumPlanSubscription;

use App\Models\PremiumPlan;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
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
        $status = '';
        $user = User::find($this->user_id);
        $plan = PremiumPlan::find($this->premium_plan_id);

        // https://stackoverflow.com/questions/19031235/php-check-if-date-is-past-to-a-certain-date-given-in-a-certain-format
        $expiry = new DateTime($this->expires_at);
        $now = new DateTime();

        if ($expiry > $now) {
            // expiry is in the future, valid subscripton is already in effect
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        // https://laraveldaily.com/post/carbon-diffforhumans-parameters-and-extra-options

        if ($plan->slug == 'waiting-list') {
            return [
                'id' => $this->id,
                'period_months' => $this->period,
                'activated_at' => Carbon::parse($this->activated_at)->format('jS F Y, H:m:s'),
                'time_ago' => Carbon::parse($this->activated_at)->diffForHumans(),
                'expires_at' => Carbon::parse($this->expires_at)->format('jS F Y, H:m:s'),
                'time_left' => Carbon::parse($this->expires_at)->diffForHumans(
                    now(),
                    Carbon::DIFF_RELATIVE_TO_NOW,
                    false,
                    2
                ),
                'subscriber' => $user->username,
                'plan' => $plan->name,
                'waiting_lists' => WaitingListResource::collection($this->waitingLists),
                'status' => $status
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
            'status' => $status
        ];
    }
}
