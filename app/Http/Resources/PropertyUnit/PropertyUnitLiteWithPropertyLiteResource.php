<?php

namespace App\Http\Resources\PropertyUnit;

use App\Http\Resources\BrandResource;
use App\Http\Resources\PropertyLiteResource;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyUnitLiteWithPropertyLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $property = $this->property;

        $plan = '';
        $published = new DateTime($property->published_at);
        if ($published >= Carbon::now()->subHours(48)) {
            // property published within the last 48 hours
            $plan = 'waiting-list';
        } else {
            // property published more than 48 hours ago
        }

        $subZone = [
            'name' => $property->subZone->name,
            'zone' => [
                'name' => $property->subZone->zone->name,
                'county' => [
                    'name' => $property->subZone->zone->zoneCounty->name
                ]
            ]
        ];

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'floor_area' => $this->floor_area,
            'bathrooms' => $this->bathrooms,
            'bedrooms' => $this->bedrooms,
            'init_deposit' => $this->init_deposit,
            'init_deposit_period' => $this->init_deposit_period,
            'thumbnail' => $this->thumbnail,
            'time_ago' => $this->created_at->diffForHumans(),
            'property' => [
                'name' => $property->name,
                'slug' => $property->slug,
                'thumbnail' => $property->thumbnail,
                'brand' => new BrandResource($property->user->brand),
                'sub_zone' => $subZone,
                'premium' => $plan,
                'time_ago' => Carbon::parse($property->published_at)->diffForHumans(),
            ]
        ];
    }
}
