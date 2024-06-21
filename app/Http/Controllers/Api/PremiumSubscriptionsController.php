<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddWaitingListRequest;
use App\Http\Resources\PremiumPlanSubscription\PremiumPlanResource;
use App\Http\Resources\PremiumPlanSubscription\SubscriptionResource;
use App\Http\Resources\PremiumPlanSubscription\WaitingListResource;
use App\Models\PremiumPlan;
use App\Models\PremiumPlanSubscription;
use App\Models\PremiumPlanWaitingList;
use App\Models\User;
use App\Models\Zone;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class PremiumSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $subscriptions = $user->premiumSubscriptions;
        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plan = PremiumPlan::find($request->id);
        if ($plan->status == 'active') {
            // plan is active
            $user = auth()->user();
    
            if ($user->userCredit->credit >= $plan->price) {
                // credit is sufficient
                $this->createSubscription($plan, $request, $user);
            } else {
                //credit is insufficient
                return response()->json([
                    'message' => "Your credit amount is insufficient to subscribe to this plan.",
                    'errors' => [
                        'telephone' => [
                            "The credit amount is insufficient",
                        ]
                    ],
                ], 422);
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createSubscription(Request $request, User $user = null) {
        if (!$user) {
            $user = auth()->user();
        }
        $data = '';
        $plan = PremiumPlan::where('slug', $request->slug)->first();
        // $subscription = PremiumPlanSubscription::where('user_id', $user->id)->where('premium_plan_id', $plan->id)->firstOrFail();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        $comment = '';

        if ($subscription) {
            // https://stackoverflow.com/questions/19031235/php-check-if-date-is-past-to-a-certain-date-given-in-a-certain-format
            $expiry = new DateTime($subscription->expires_at);
            $now = new DateTime();

            if ($expiry > $now) {
                // expiry is in the future, valid subscripton is already in effect
                return response()->json([
                    'message' => "Your subscription to this plan is still active.",
                    'errors' => [
                        'subscription_plan' => [
                            "The subscription is still active",
                        ]
                    ],
                ], 422);
            }
            $data = $subscription;
        } else {
            $data = new PremiumPlanSubscription();
            $data->premium_plan_id = $plan->id;
            $data->user_id = $user->id;
        }
        $data->period = $plan->minimum_days;
        $data->activated_at = date("Y-m-d H:i:s");
        // https://www.codexworld.com/how-to/add-days-hours-minutes-seconds-to-datetime-php/
        $data->expires_at = date('Y-m-d H:i:s', strtotime('+'.$plan->minimum_days.' days', strtotime($data->activated_at)));
        $data->save();

        $response = [
            'premium_plan_subscription' => $data,
            'model' => 'PremiumPlanSubscription',
            'key' => $data->id,
            'comment' => $comment,
            'message' => "New subscription for plan ".$plan->name." activated for user @".$user->username.".",
        ];
        return response($response, 201);
    }

    public function addWaitingList(AddWaitingListRequest $request) {
        $comment = '';
        $user = auth()->user();
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        $zone = Zone::find($request->zone_id);

        $data = new PremiumPlanWaitingList();
        $data->subscription_id = $subscription->id;
        $data->zone_id = $request->zone_id;
        try {
            $data->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => "You are already in this zone's waiting list.",
                'errors' => [
                    'zone_id' => [
                        "You are aleady in this zone's waiting list",
                    ]
                ],
            ], 422);
        }

        $response = [
            'premium_plan_waiting_list' => new WaitingListResource($data),
            'message' => "New waiting list added for zone ".$zone->name." under subscription #".$subscription->id." for user @".$user->username.".",
        ];
        return response($response, 201);
    }

    public function removeWaitingList(Zone $zone) {
        $comment = '';
        $user = auth()->user();
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        
        $data = $subscription->waitingLists()->where('zone_id', $zone->id)->first();
        $data->delete();

        $response = [
            'premium_plan_waiting_list' => response()->noContent(),
            'message' => "Waiting list for zone ".$zone->name." under subscription #".$subscription->id." for user @".$user->username." removed.",
        ];
        return response($response, 201);
    }

    public function getWaitingLists() {
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();

        try {
            $subscription = auth()->user()->premiumSubscriptions()->where('premium_plan_id', $plan->id)->firstOrFail();
            return new SubscriptionResource($subscription);
        } catch (Exception $e) {
            return response()->noContent();
        }
    }

    public function getPremiumPlan(PremiumPlan $plan) {
        return new PremiumPlanResource($plan);
    }
}
