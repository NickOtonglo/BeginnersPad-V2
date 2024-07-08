<?php

namespace App\Http\Resources;

use App\Models\PropertyReview;
use App\Models\PropertyUnit;
use Carbon\Carbon;
use DateTime;
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
        
        $plan = '';
        $published = new DateTime($this->published_at);
        if ($published >= Carbon::now()->subHours(48)) {
            // property published within the last 48 hours
            $plan = 'waiting-list';
        } else {
            // property published more than 48 hours ago
        }

        if ($this->status == 'published' && $this->published_at )

        $subZone = [
            'name' => $this->subZone->name,
            'zone' => [
                'name' => $this->subZone->zone->name,
                'county' => [
                    'name' => $this->subZone->zone->zoneCounty->name
                ]
            ]
        ];
        
        $rentMin = 0;
        $rentMax = 0;
        $floorSizeMin = 0;
        $floorSizeMax = 0;
        $bedroomsMin = 0;
        $bedroomsMax = 0;
        $bathroomsMin = 0;
        $bathroomsMax = 0;
        if (!PropertyUnit::where('property_id', $this->id)->get()->isEmpty()) {
            $rentMin = intval(PropertyUnit::where('property_id', $this->id)->orderBy('price')->first()->price);
            $rentMax = intval(PropertyUnit::where('property_id', $this->id)->orderByDesc('price')->first()->price);
            $floorSizeMin = PropertyUnit::where('property_id', $this->id)->orderBy('floor_area')->first()->floor_area;
            $floorSizeMax = PropertyUnit::where('property_id', $this->id)->orderByDesc('floor_area')->first()->floor_area;
            $bedroomsMin = PropertyUnit::where('property_id', $this->id)->orderBy('bedrooms')->first()->bedrooms;
            $bedroomsMax = PropertyUnit::where('property_id', $this->id)->orderByDesc('bedrooms')->first()->bedrooms;
            $bathroomsMin = PropertyUnit::where('property_id', $this->id)->orderBy('bathrooms')->first()->bathrooms;
            $bathroomsMax = PropertyUnit::where('property_id', $this->id)->orderByDesc('bathrooms')->first()->bathrooms;
        }

        $window = [
            'rent_min' => $rentMin,
            'rent_max' => $rentMax,
            'floor_size_min' => $floorSizeMin,
            'floor_size_max' => $floorSizeMax,
            'bedrooms_min' => $bedroomsMin,
            'bedrooms_max' => $bedroomsMax,
            'bathrooms_min' => $bathroomsMin,
            'bathrooms_max' => $bathroomsMax,
        ];

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'status' => $this->status,
            'verified' => $this->verified,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'timestamp' => Carbon::parse($this->published_at)->format('jS F Y, H:m:s'),
            'time_ago' => Carbon::parse($this->published_at)->diffForHumans(),
            'window' => $window,
            'rating' => number_format($rating, 1),
            'brand' => new BrandResource($this->user->brand),
            'sub_zone' => $subZone,
            'premium' => $plan,
        ];
    }
}
