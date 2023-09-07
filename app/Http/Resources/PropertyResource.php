<?php

namespace App\Http\Resources;

use App\Models\PropertyFeature;
use App\Models\PropertyFile;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $features = PropertyFeature::where('property_id', $this->id)->get();
        $files = PropertyFile::where('property_id', $this->id)->get();
        $units = PropertyUnit::where('property_id', $this->id)->get();

        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'user_id' => $this->user_id,
            'sub_zone_id' => $this->sub_zone_id,
            'status' => $this->status,
            'verified' => $this->verified,
            'description' => $this->description,
            'stories' => $this->stories,
            'thumbnail' => $this->thumbnail,
            'timestamp' => $this->created_at->format('jS F Y,  H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'features' => PropertyFeaturesResource::collection($features),
            'files' => PropertyFilesResource::collection($files),
            'brand' => new BrandResource($this->user->brand),
            'sub_zone' => new SubZoneResource($this->subZone),
            'units' => PropertyUnitLiteResource::collection($units),
        ];
    }
}
