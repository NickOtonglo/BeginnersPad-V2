<?php

namespace App\Http\Resources\PremiumPlanSubscription;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WaitingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $zone = Zone::find($this->zone_id);

        return [
            'id' => $this->id,
            'subscription_id' => $this->subscription_id,
            'zone_id' => $this->zone_id,
            'zone' => $zone->name,
            'radius' => number_format($zone->radius*0.001, 3),
            'properties_count' => $zone->properties()->where('status', 'published')->count(),
            'county' => $zone->zoneCounty->name,
        ];
    }
}
