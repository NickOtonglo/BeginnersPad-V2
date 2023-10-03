<?php

namespace App\Http\Resources;

use App\Models\PropertyFeature;
use App\Models\PropertyFile;
use App\Models\PropertyReview;
use App\Models\PropertyUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $features = PropertyFeature::where('property_id', $this->id)->get(['item']);
        $files = PropertyFile::where('property_id', $this->id)->get(['name']);
        $units = PropertyUnit::where('property_id', $this->id)->get();
        $user = User::where('id', $this->user_id)->first()->username;
        $subZone = [
            'name' => $this->subZone->name,
            'zone' => [
                'name' => $this->subZone->zone->name,
                'county' => [
                    'name' => $this->subZone->zone->zoneCounty->name
                ]
            ]
        ];
        $rating = PropertyReview::where('property_id', $this->id)->avg('rating');

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
            'user_name' => $user,
            'status' => $this->status,
            'verified' => $this->verified,
            'description' => $this->description,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'window' => $window,
            'rating' => number_format($rating, 1),
            'features' => PropertyFeaturesResource::collection($features),
            'files' => PropertyFilesResource::collection($files),
            'brand' => new BrandResource($this->user->brand),
            'sub_zone' => $subZone,
            'units' => PropertyUnitLiteResource::collection($units),
        ];
    }
}
