<?php

namespace App\Http\Resources;

use App\Models\PropertyReview;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rating = PropertyReview::where('property_id', $this->id)->avg('rating');

        $subZone = [
            'name' => $this->subZone->name,
            'zone' => [
                'name' => $this->subZone->zone->name,
                'county' => [
                    'name' => $this->subZone->zone->zoneCounty->name
                ]
            ]
        ];
        
        $window = [
            'rent_min' => intval(PropertyUnit::where('property_id', $this->id)->orderBy('price')->first()->price),
            'rent_max' => intval(PropertyUnit::where('property_id', $this->id)->orderByDesc('price')->first()->price),
            'floor_size_min' => PropertyUnit::where('property_id', $this->id)->orderBy('floor_area')->first()->floor_area,
            'floor_size_max' => PropertyUnit::where('property_id', $this->id)->orderByDesc('floor_area')->first()->floor_area,
            'bedrooms_min' => PropertyUnit::where('property_id', $this->id)->orderBy('bedrooms')->first()->bedrooms,
            'bedrooms_max' => PropertyUnit::where('property_id', $this->id)->orderByDesc('bedrooms')->first()->bedrooms,
            'bathrooms_min' => PropertyUnit::where('property_id', $this->id)->orderBy('bathrooms')->first()->bathrooms,
            'bathrooms_max' => PropertyUnit::where('property_id', $this->id)->orderByDesc('bathrooms')->first()->bathrooms,
        ];

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => $this->status,
            'verified' => $this->verified,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'window' => $window,
            'rating' => number_format($rating, 1),
            'brand' => new BrandResource($this->user->brand),
            'sub_zone' => $subZone,
        ];
    }
}
