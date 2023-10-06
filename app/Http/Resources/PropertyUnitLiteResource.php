<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyUnitLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $property = $this->property;

        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_slug' => $property->slug,
            'price' => $this->price,
            'floor_area' => $this->floor_area,
            'bathrooms' => $this->bathrooms,
            'bedrooms' => $this->bedrooms,
            'init_deposit' => $this->init_deposit,
            'init_deposit_period' => $this->init_deposit_period,
            'thumbnail' => $this->thumbnail,
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
