<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubZoneResource extends JsonResource
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
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'radius' => $this->radius*0.001,
            'description' => $this->description,
            'timestamp' => $this->created_at->format('jS F Y'),
            'nature_id' => $this->nature_id,
            'zone_id' => $this->zone_id,
            'nature' => new SubZoneNatureResource($this->nature),
            'zone' => new ZonesResource($this->zone),
        ];
    }
}
