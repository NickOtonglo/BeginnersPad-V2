<?php

namespace App\Http\Resources;

use App\Models\PropertyUnitFeature;
use App\Models\PropertyUnitFile;
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
        $files = PropertyUnitFile::where('property_unit_id', $this->id)->get();

        $disclaimer = [];
        $disclaimerAssorted = explode(' || ', $this->disclaimer);
        foreach ($disclaimerAssorted as $item) {
            array_push($disclaimer, $item);
        }
        array_shift($disclaimer);

        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'init_deposit' => $this->init_deposit,
            'init_deposit_period' => $this->init_deposit_period,
            'story' => $this->story,
            'floor_area' => $this->floor_area,
            'bathrooms' => $this->bathrooms,
            'bedrooms' => $this->bedrooms,
            'disclaimer' => $disclaimer,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'property_id' => $this->property_id,
            'timestamp' => $this->created_at->format('jS F Y,  H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
            'features' => PropertyUnitFeatureResource::collection($features),
            'files' => PropertyUnitFileResource::collection($files),
            'property' => new PropertyResource($this->property),
        ];
    }
}
