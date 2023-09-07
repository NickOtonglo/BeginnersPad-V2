<?php

namespace App\Http\Resources;

use App\Models\PropertyUnitFeature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $features = PropertyUnitFeature::where('property_unit_id', $this->id)->get();
        // $files = PropertyFile::where('property_id', $this->id)->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'init_deposit' => $this->init_deposit,
            'init_deposit_period' => $this->init_deposit_period,
            'story' => $this->story,
            'floor_area' => $this->floor_area,
            'disclaimer' => $this->disclaimer,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'property_id' => $this->property_id,
            'features' => PropertyUnitFeatureResource::collection($features),
            'files' => '',
        ];
    }
}
