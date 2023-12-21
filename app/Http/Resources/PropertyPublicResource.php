<?php

namespace App\Http\Resources;

use App\Models\PropertyFeature;
use App\Models\PropertyFile;
use App\Models\PropertyReview;
use App\Models\PropertyUnit;
use App\Models\User;
use App\Models\UserFavourite;
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
        $favourite = UserFavourite::where('model', 'Property')->where('model_id', $this->id)->where('user_id', auth()->user()->id)->first();
        $favourite_count = UserFavourite::where('model', 'Property')->where('model_id', $this->id)->count();
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
            'favourite' => new UserFavouriteLiteResource($favourite),
            'favourite_count' => $favourite_count,
        ];
    }
}
