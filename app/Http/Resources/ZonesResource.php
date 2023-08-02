<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'radius' => $this->radius*0.001,
            'timezone' => $this->timezone,
            'description' => $this->description,
            'timestamp' => $this->created_at->format('jS F Y'),
            'county_code' => $this->county_code,
        ];
    }
}
